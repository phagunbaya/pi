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
 * Author element helper
 * Helper cannot be used in other module
 *
 * @author Zongshu Lin <lin40553024@163.com>
 */
class Author extends AbstractCustomHelper
{
    /**
     * {@inheritDoc}
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
        $this->view->bootstrap('js/bootstrap-typeahead.js');

        $required = $element->getAttribute('required');
        $url      = Pi::service('url')->assemble('default', array(
            'controller' => 'ajax',
            'action'     => 'get.fuzzy.author',
        ));
        $authorId = $element->getValue();
        $title    = '';
        if ($authorId) {
            $module = Pi::service('module')->current();
            $row    = Pi::model('author', $module)->find($authorId);
            $title  = $row->name . "[{$row->id}]";
        }
        
        $attributes = $element->getAttributes();
        $this->assign(array(
            'title'      => $title,
            'name'       => $element->getName(),
            'required'   => $required ? 'required="required"' : '',
            'author_id'  => $authorId,
            'attributes' => $this->createAttributesString($attributes),
            'url'        => $url,
        ));

        return $this->getTemplate($element);
    }
}
