<?php

namespace Xitara\Accordion\Classes;

use Xitara\Accordion\Models\TextList;
use October\Rain\Support\Collection;
use OFFLINE\SiteSearch\Classes\Providers\ResultsProvider;
use RainLab\Pages\Classes\Page;

class AccordionSearchProvider extends ResultsProvider
{
    public function search()
    {
        // Search your plugin's contents
        $items = TextList::where('textlist', 'like', "%{$this->query}%")
            ->get();

        foreach ($items as $key => $item) {
            $ids = (new Collection($item->textlist))->map(function ($item, $key) {
                if (mb_stripos($item['text'], $this->query) !== false) {
                    return $key;
                }
            });

            foreach ($this->checkPages($item->id) as $page) {
                /**
                 * get some available content
                 */
                $content = $page->parsedMarkup;

                if ($content == '') {
                    foreach ($page->placeholders as $key => $placeholder) {
                        if ($placeholder != '') {
                            $content = $placeholder;
                            break;
                        }
                    }
                }

                $result = $this->newResult();
                $result->relevance = 1;
                $result->title = $page->title;
                $result->text = $content;
                $result->url = $page->url;
                // $result->thumb = $page->image;
                $result->model = $page;
                $result->meta = [
                    'open' => join(',', $ids->toArray()),
                ];
            }

            // Add the results to the results collection
            $this->addResult($result);
        }

        return $this;
    }

    private function checkPages($id)
    {
        return Page::all()->filter(function ($page) use ($id) {
            $viewBag = $page->viewBag;
            $isHidden = isset($viewBag['is_hidden']) ? (bool) $viewBag['is_hidden'] : false;

            if ($isHidden) {
                return false;
            }

            $search = 'data-property-textlist="' . $id . '"';

            try {
                return $this->containsQuery($page->parsedMarkup, $search)
                || $this->containsQuery($page->placeholders, $search)
                || $this->viewBagContainsQuery($viewBag, $search);
            } catch (\Throwable $e) {
                // If an exception was thrown chances are that a page contained invalid markup.
                return false;
            }
        });
    }

    /**
     * Checks if $subject contains the query string.
     *
     * @param $subject
     *
     * @return bool
     */
    protected function containsQuery($subject, $search)
    {
        return is_array($subject)
        ? $this->arrayContainsQuery($subject, $search)
        : mb_strpos(mb_strtolower($subject), mb_strtolower($search)) !== false;
    }

    /**
     * Checks if a viewBag contains the query string.
     *
     * @param $viewBag
     *
     * @return bool
     */
    protected function viewBagContainsQuery($viewBag, $search)
    {
        $ignoreViewBagKeys = [
            'url',
            'layout',
            'is_hidden',
            'navigation_hidden',
        ];

        $properties = collect($viewBag)->except($ignoreViewBagKeys)->toArray();

        return $this->arrayContainsQuery($properties, $search);
    }

    /**
     * Checks if an array contains the query string.
     *
     * @param $array
     *
     * @return bool
     */
    protected function arrayContainsQuery(array $array, $search)
    {
        foreach ($array as $value) {
            if ($this->containsQuery($value, $search)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get the page's (translated) url.
     *
     * @param $page
     *
     * @return string
     */
    protected function getUrl($page)
    {
        $langPrefix = $this->translator ? $this->translator->getLocale() : '';

        return $langPrefix . $page->viewBag['url'];
    }

    public function displayName()
    {
        return 'Accordion Result';
    }

    public function identifier()
    {
        return 'Xitara.Accordion';
    }
}
