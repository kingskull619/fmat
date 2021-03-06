<?php namespace App;

use Landish\Pagination\Pagination as BasePagination;


class MaterialPagination extends BasePagination {

  /**
   * Available page wrapper HTML.
   *
   * @var string
   */
  protected $availablePageWrapper = '<li class="waves-effect"><a href="%s">%s</a></li>';

  /**
   * Get active page wrapper HTML.
   *
   * @var string
   */
  protected $activePageWrapper = '<li class="active"><a href="#!">%s</a></li>';

  /**
   * Get disabled page wrapper HTML.
   *
   * @var string
   */
  protected $disabledPageWrapper = '<li class="disabled"><a href="#!">%s</a></li>';

  /**
   * Previous button text.
   *
   * @var string
   */
  protected $previousButtonText = '<i class="mdi-navigation-chevron-left"></i>';

  /**
   * Next button text.
   *
   * @var string
   */
  protected $nextButtonText = '<i class="mdi-navigation-chevron-right"></i>';

}
