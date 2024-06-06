<?php

return [
	'name' => 'Ihelpers',
	'configurationv2'=>[
		/*[
			'Name'=>'Products',
			'Categories'=>true,
			'Repository'=>'Modules\Icommerce\Repositories\CategoryRepository',
			'RepositoryItems'=>'Modules\Icommerce\Repositories\ProductRepository'

		],*/
		[
			'Name'=>'Pages',
			'Categories'=>false,
			'Repository'=>'Modules\Page\Repositories\PageRepository'
		],
		[
			'Name'=>'Posts',
			'Categories'=>true,
			'Repository'=>'Modules\Iblog\Repositories\CategoryRepository',
			'RepositoryItems'=>'Modules\Iblog\Repositories\PostRepository'
		],
		/*[
			'Name'=>'Manufacturers',
			'Categories'=>false,
			'Repository'=>'Modules\Icommerce\Repositories\ManufacturerRepository'
		]*/
	]
];
