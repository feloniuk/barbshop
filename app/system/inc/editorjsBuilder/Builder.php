<?php

/**
 * Class Builder
 */
class Builder
{
    private string $json = '';
    private array $blocks = [];
    private string $content = '';

    /**
     * Builder constructor.
     *
     * @param $json
     */
    public function __construct($json)
    {
        $this->json = $json;
    }

    /**
     * Splits the json string into separate blocks.
     *
     * @throws Exception
     */
    public function processJson()
    {
        if (empty($this->json)) {
            throw new Exception('JSON is empty');
        }

        $data = json_decode($this->json, true);

        if (json_last_error()) {
            throw new Exception('Wrong JSON format: ' . json_last_error_msg());
        }

        if (is_null($data)) {
            throw new Exception('Input is null');
        }

        if (count($data) === 0) {
            throw new Exception('Input array is empty');
        }

        if (!isset($data['blocks'])) {
            throw new Exception('Field `blocks` is missing');
        }

        if (!is_array($data['blocks'])) {
            throw new Exception('Blocks is not an array');
        }

        foreach ($data['blocks'] as $blockData) {
            if (is_array($blockData)) {
                $this->blocks[] = $blockData;
            } else {
                throw new Exception('Block must be an Array');
            }
        }
    }

    /**
     * Marking methods.
     *
     * @return string
     */
    public function getBlocks()
    {
        foreach ($this->blocks as $block) {
            switch ($block['type']) {
                case 'paragraph':
                    $this->content .= '<p>' . $block['data']['text'] . '</p>';
                    break;
                case 'header':
                    $this->content .= '<h' . $block['data']['level'] . '>' . $block['data']['text'] . '</h' . $block['data']['level'] . '>';
                    break;
                case 'delimiter':
                    $this->content .= '<hr />';
                    break;
                case 'list':
                    $this->content .= $this->getListMark($block['data']);
                    break;
                case 'image':
                    $this->content .= $this->getImageMark($block['data']);
                    break;
                case 'quote':
                    $this->content .= '<div class="quote"><blockquote style="alignment: ' . $block['data']['alignment'] . '">' . $block['data']['text'] . '</blockquote> - ' . $block['data']['caption'] . '</div>';
                    break;
                case 'code':
                    $this->content .= '<pre><code>' . base64_decode($block['data']['code']) . '</code></pre>';
                    break;
                case 'embed':
                    $this->content .= $this->getEmbedMark($block);
                    break;
                case 'raw':
                    $this->content .= base64_decode($block['data']['html']);
                    break;
                case 'personality':
                    $this->content .= $this->getPersonalityMark($block['data']);
                    break;
                case 'checklist':
                    $this->content .= $this->getChecklistMark($block['data']);
                    break;
                case 'warning':
                    $this->content .= $this->getWarningMark($block['data']);
                    break;
                case 'table':
                    $this->content .= $this->getTableMark($block['data']);
                    break;
                case 'linkTool':
                    $this->content .= $this->getLinkMark($block['data']);
                    break;
            }
        }

        return $this->content;
    }

    private function getImageMark($data)
    {
        $caption = $data['caption'] ?: "Image";
        $url = $data['file'] && $data['file']['url'] ? $data['file']['url'] : $data['url'];

        return '<img src="' . $url . '" alt="' . $caption . '" />';
    }

    private function getEmbedMark($data)
    {
        switch ($data['service']) {
            case "vimeo":
                return '<iframe src="' . $data['embed'] . '" height="' . $data['height'] . '" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>';
            case "youtube":
                return '<iframe width="' . $data['width'] . '" height="' . $data['height'] . '" src="' . $data['embed'] . '" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
            default:
                throw new Error("Only Youtube and Vime Embeds are supported right now.");
        }
    }

    private function getListMark($data)
    {
        $listStyle = $data['style'] === "unordered" ? "ul" : "ol";

        $results = '';

        foreach ($data['items'] as $item) {
            $results .= '<li>' . $item . '</li>';
        }

        return '<' . $listStyle . '>' . $results . '</' . $listStyle . '>';
    }

    private function getPersonalityMark($data)
    {
        $html = '
            <div class="personality">
                <div class="personality__info">
                    <div class="personality__name">
                        ' . $data['name'] . '
                    </div>
                    <div class="personality__description">
                        ' . $data['description'] . '
                    </div>
                    <a href="' . $data['link'] . '">Link</a>
                </div>
                <img src="' . $data['photo'] . '" alt="Photo" />
            </div>
        ';

        return $html;
    }

    private function getChecklistMark($data)
    {
        $results = '';

        $last = array_key_last($data['items']);

        foreach ($data['items'] as $key => $item) {
            $id = str_replace(' ', '_', $item['text']);
            $checked = $item['checked'] ? 'checked' : '';

            $results .= '<input type="checkbox" onClick="return false;" id="' . $id . '" value="' . $id . '" ' . $checked . '>';
            $results .= '<label for="' . $id . '"> ' . $item['text'] . '</label>';

            if ($key != $last) {
                $results .= '<br>';
            }
        }

        return $results;
    }

    private function getWarningMark($data)
    {
        return '
            <div class="alert alert-info" role="alert">
                <label>' . $data['title'] . '</label>
                ' . $data['message'] . '
            </div>
        ';
    }

    private function getTableMark($data)
    {
        $result = '';

        foreach ($data['content'] as $key => $row) {
            $result .= '<tr>';

            if ($data['withHeadings'] && $key == 0) {
                foreach ($row as $column) {
                    $result .= '<th>' . $column . '</th>';
                }
            } else {
                foreach ($row as $column) {
                    $result .= '<td>' . $column . '</td>';
                }
            }

            $result .= '</tr>';
        }

        return '<table>' . $result . '</table>';
    }

    private function getLinkMark($data)
    {
        $image = $data['meta']['image']['url'];
        $link = str_ireplace(['http://', 'https://'], ['', ''], rtrim($data['link'], '/'));

        return '
            <div class="link-tool">
                <a class="link-tool__content link-tool__content--rendered" 
                    target="_blank"
                    rel="nofollow noindex noreferrer" 
                    href="' . processUrl($data['link']) . '">
                    
                    <img src="' . $image . '" alt="' . $data['meta']['title'] . '">
                    
                    <div class="link-tool__title">
                        ' . $data['meta']['title'] . '
                    </div>
                    <p class="link-tool__description">
                        ' . $data['meta']['description'] . '
                    </p>
                    <span class="link-tool__anchor">' . $link . '</span>
                </a>
            </div>
        ';
    }
}
