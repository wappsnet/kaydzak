<?php
namespace Plugins;

use Wappsnet\Core\Plugin;

class Pagination extends Plugin
{
	public static $paginate = Array(
		'string' => '?page=%#%',
		'parser' => '%_%',
		'this' => 1
	);

	protected function setData() {
		$pageItemsCount = 0;

		if(isset($this->args['count'])) {
			$pageItemsCount = $this->args['count'];
		}

		self::$paginate['data'] = self::getPaginationData($pageItemsCount);
		self::$paginate['total'] = ceil(self::$paginate['data']['count']/self::$paginate['data']['limit']);
		self::$paginate['page'] = max(1, self::$paginate['data']['page']);
		self::$paginate['link'] = self::$paginate['string'];

		if(self::$paginate['this'] == 1) {
			self::$paginate['link'] = '';
		};

		self::$paginate['base'] = str_replace(self::$paginate['parser'], self::$paginate['link'], self::$paginate['string']);

		$pageArguments = [
			'base'      => self::$paginate['base'],
			'format'    => self::$paginate['string'],
			'current'   => self::$paginate['page'],
			'total'     => self::$paginate['total'],
			'show_all'  => false,
			'end_size'  => 1,
			'mid_size'  => 2,
			'prev_next' => true,
			'prev_text' => __('«'),
			'next_text' => __('»'),
			'type'      => 'plain',
			'add_args'  => false
		];

		$pagination = paginate_links($pageArguments);

		$this->data['pagination'] = $pagination;
	}

	public static function getPaginationData($count = false) {
		global $wp_query;

		$postPerPage  = get_option('posts_per_page');
		$pageNumber   = get_query_var('page');
		$currentPage  = ($pageNumber) ? $pageNumber : 1;
		$itemsCount   = ($count) ? $count : $wp_query->queried_object->count;

		return [
			'count' => $itemsCount,
			'limit' => $postPerPage,
			'page'  => $currentPage
		];
	}
}