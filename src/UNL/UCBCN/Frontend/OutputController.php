<?php
namespace UNL\UCBCN\Frontend;

class OutputController extends \Savvy
{
    protected $theme = 'default';
    protected $controller = false;

    public function __construct(Controller $controller)
    {
        $this->controller = $controller;
        \Savvy_ClassToTemplateMapper::$classname_replacement = __NAMESPACE__ . '\\';
        parent::__construct();
        $this->initialize($this->controller->options);
    }

    public function initialize($options = array())
    {

        switch ($options['format']) {
            case 'json':
                header('Content-type:application/json');
                $this->sendCORSHeaders();
                $this->setTemplateFormatPaths($options['format']);
                break;

            case 'ics':
            case 'ical':
            case 'icalendar':
                header('Content-type:text/calendar');
                header('Content-Disposition: attachment; filename="events.ics"');
                $this->setTemplateFormatPaths('icalendar');
                break;

            case 'pdf':
                header('Content-type:application/pdf');
                $this->setTemplateFormatPaths($options['format']);
                break;

            case 'xml':
                header('Content-type:text/xml');
                $this->setTemplateFormatPaths($options['format']);
                break;

            case 'rss':
                header('Content-type:application/rss+xml; charset=UTF-8');
                $this->sendCORSHeaders();
                $this->setTemplateFormatPaths($options['format']);
                break;

            case 'csv':
                if (!isset($this->options['delimiter'])) {
                    $this->options['delimiter'] = ',';
                }

                $this->addGlobal('delimiter', $this->options['delimiter']);
                $this->addGlobal('delimitArray', function($delimiter, $array){
                    $out = fopen('php://output', 'w');
                    fputcsv($out, $array, $delimiter);
                });

                $filename = str_replace("\\", "_", $options['model']) . "." . $options['format'];
                header('Content-disposition: attachment; filename=' . $filename);

            case 'txt':
                header('Content-type:text/plain;charset=UTF-8');
                $this->setTemplateFormatPaths($options['format']);
                break;

            case 'image':
                if (isset($this->controller->output->event)) {
                    header('Content-type: '.$this->controller->output->event->imagemime);
                }
                $this->setTemplateFormatPaths($options['format']);
                break;
            case 'partial':
            case 'hcalendar':
                $this->sendCORSHeaders();
                \Savvy_ClassToTemplateMapper::$output_template[__NAMESPACE__ . '\Controller'] = 'Controller-partial';
                // intentional no-break

            case 'html':
                // Always escape output, use $context->getRaw('var'); to get the raw data.
                $this->setEscape(function($data) {
                    return htmlspecialchars($data, ENT_QUOTES, 'UTF-8', false);
                });
                header('Content-type:text/html;charset=UTF-8');
                $this->setTemplateFormatPaths('html');
                if ($options['format'] == 'hcalendar') {
                    //For the hcalendar format, we may want to customize some templates, but we should fall back on html.
                    $themes = $this->getTemplateFormatPaths('hcalendar');
                    $this->addTemplatePath($themes);
                }
                $this->addFilters(array(new OutputController\PostRunFilter\HTML($options), 'postRun'));
                break;
            default:
                throw new UnexpectedValueException('Invalid/unsupported output format', 500);
        }
    }

    /**
     * Set a specific theme for this instance
     * 
     * @param string $theme Theme name, which corresponds to a directory in www/
     * 
     * @throws Exception
     */
    public function setTheme($theme)
    {
        if (!is_dir($this->getWebDir() . '/themes/'.$theme)) {
            throw new Exception('Invalid theme, there are no files in '.$dir);
        }
        $this->theme = $theme;
    }

    /**
     * Set the array of template paths necessary for this format
     * 
     * @param string $format Format to use
     */
    public function setTemplateFormatPaths($format)
    {
        $themes = $this->getTemplateFormatPaths($format);

        $this->setTemplatePath($themes);
    }
    
    public function getTemplateFormatPaths($format)
    {
        $web_dir = $this->getWebDir();

        // The 'default' theme is always on the path as a fallback
        $themes = array(
            $web_dir . '/templates/default/', //add the default as a path so that we can reference other formats when rendering
            $web_dir . '/templates/default/' . $format
        );

        // If we've customized the theme, add that directory to the path
        if ($this->theme != 'default') {
            $themes[] = $web_dir . '/templates/' . $this->theme . '/' . $format;
        }
        
        return $themes;
    }

    /**
     * Get the path to the root web directory
     *
     * @return string
     */
    protected function getWebDir()
    {
        return dirname(dirname(dirname(dirname(__DIR__)))) . '/www';
    }

    public function setReplacementData($field, $data)
    {
        foreach ($this->getConfig('filters') as $filter) {
            $filter[0]->setReplacementData($field, $data);
        }
    }

    /**
     * 
     * @param timestamp $expires timestamp
     * 
     * @return void
     */
    function sendCORSHeaders($expires = null)
    {
        // Specify domains from which requests are allowed
        header('Access-Control-Allow-Origin: *');

        // Specify which request methods are allowed
        header('Access-Control-Allow-Methods: GET, OPTIONS');

        // Additional headers which may be sent along with the CORS request
        // The X-Requested-With header allows jQuery requests to go through

        header('Access-Control-Allow-Headers: X-Requested-With');

        // Set the ages for the access-control header to 20 days to improve speed/caching.
        header('Access-Control-Max-Age: 1728000');

        if (isset($expires)) {
            // Set expires header for 24 hours to improve speed caching.
            header('Expires: '.date('r', $expires));
        }
    }

    /**
     * This function converts a string stored in the database to html output.
     * & becomes &amp; etc.
     *
     * @param $text
     * @internal param string $t Normally a varchar string from the database.
     *
     * @return String encoded for output to html.
     */
    function dbStringToHtml($text)
    {
        return nl2br(htmlspecialchars($text));
    }

}
