<?php
/**
 * Pi Engine (http://pialog.org)
 *
 * @link            http://code.pialog.org for the Pi Engine source repository
 * @copyright       Copyright (c) Pi Engine http://pialog.org
 * @license         http://pialog.org/license.txt New BSD License
 * @package         Form
 */

namespace Module\Article\Form\View\Helper;

use Zend\Form\ElementInterface;
use Pi;

/**
 * Time publish element helper
 *
 * @author Zongshu Lin <lin40553024@163.com>
 */
class TimePublish extends AbstractCustomHelper
{
    /**
     * Invoke helper as function
     *
     * Proxies to {@link render()}.
     *
     * @param  ElementInterface|null $element
     * @return string|self
     */
    public function __invoke(ElementInterface $element = null)
    {
        if (!$element) {
            return $this;
        }

        return $this->render($element);
    }

    /**
     * {@inheritDoc}
     */
    public function render(ElementInterface $element)
    {
        $locale = Pi::config('locale');
        if (false !== strpos('-', $locale)) {
            $list = explode('-', $locale, 2);
            $locale = $list[0] . '-' . strtoupper($list[1]);
        }
        $datepickerLocale = sprintf(
            'datepicker/locales/bootstrap-datepicker.%s.js',
            $locale
        );
        $this->view->bootstrap(array(
            'datepicker/datepicker.css',
            'datepicker/bootstrap-datepicker.js',
            $datepickerLocale,
        ));

        $required = $element->getAttribute('required');
        
        $time = $element->getValue();
        $date = $hour = $minute = $second = '';
        if ($time) {
            list($date, $dateTime) = explode(' ', $time);
            if ($dateTime) {
                list($hour, $minute, $second) = explode(':', $dateTime);
            }
        }
        
        $attributes = $element->getAttributes();
        $this->assign(array(
            'name'       => $element->getName(),
            'value'      => $element->getValue(),
            'date'       => $date,
            'hour'       => $hour,
            'minute'     => $minute,
            'required'   => $required ? 'required="required"' : '',
            'attributes' => $this->createAttributesString($attributes),
        ));
        
        return $this->getTemplate($element);
    }
}
