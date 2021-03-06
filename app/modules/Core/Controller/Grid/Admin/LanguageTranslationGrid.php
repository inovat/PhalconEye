<?php
/*
  +------------------------------------------------------------------------+
  | PhalconEye CMS                                                         |
  +------------------------------------------------------------------------+
  | Copyright (c) 2013-2014 PhalconEye Team (http://phalconeye.com/)       |
  +------------------------------------------------------------------------+
  | This source file is subject to the New BSD License that is bundled     |
  | with this package in the file LICENSE.txt.                             |
  |                                                                        |
  | If you did not receive a copy of the license and are unable to         |
  | obtain it through the world-wide-web, please send an email             |
  | to license@phalconeye.com so we can send you a copy immediately.       |
  +------------------------------------------------------------------------+
  | Author: Ivan Vorontsov <ivan.vorontsov@phalconeye.com>                 |
  +------------------------------------------------------------------------+
*/

namespace Core\Controller\Grid\Admin;

use Core\Controller\Grid\CoreGrid;
use Core\Model\Language;
use Engine\Db\AbstractModel;
use Engine\DependencyInjection;
use Engine\Form;
use Engine\Grid\GridItem;
use Phalcon\Mvc\Model\Query\Builder;
use Phalcon\Mvc\Model\Row;
use Phalcon\Mvc\View;
use Phalcon\Mvc\ViewInterface;

/**
 * Language translation grid.
 *
 * @category  PhalconEye
 * @package   Core\Controller\Grid\Admin
 * @author    Ivan Vorontsov <ivan.vorontsov@phalconeye.com>
 * @copyright 2013-2014 PhalconEye Team
 * @license   New BSD License
 * @link      http://phalconeye.com/
 */
class LanguageTranslationGrid extends CoreGrid
{
    /**
     * Current language.
     *
     * @var Language
     */
    protected $_language;

    /**
     * Create grid.
     *
     * @param ViewInterface $view     View object.
     * @param Language      $language language object.
     */
    public function __construct(ViewInterface $view, Language $language)
    {
        $this->_language = $language;
        parent::__construct($view);
    }

    /**
     * Get main select builder.
     *
     * @return Builder
     */
    public function getSource()
    {
        $builder = new Builder();
        $builder->from('Core\Model\LanguageTranslation');

        if ($search = $this->getDI()->getRequest()->get('search')) {
            $builder
                ->where("t.original LIKE '%{$search}%'")
                ->orWhere("t.translated LIKE '%{$search}%'");
        }

        return $builder;
    }

    /**
     * Get item action (Edit, Delete, etc).
     *
     * @param GridItem $item One item object.
     *
     * @return array
     */
    public function getItemActions(GridItem $item)
    {
        return [
            'Edit' => ['attr' => ['onclick' => 'editItem(' . $item['id'] . ');return false;']],
            'Delete' => ['attr' => ['onclick' => 'deleteItem(' . $item['id'] . ');return false;']]
        ];
    }

    /**
     * Initialize grid columns.
     *
     * @return array
     */
    protected function _initColumns()
    {
        $this
            ->addTextColumn('original', 'Original')
            ->addTextColumn('translated', 'Translated');
    }
}