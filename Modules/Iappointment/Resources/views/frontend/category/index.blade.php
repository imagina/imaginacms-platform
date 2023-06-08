@extends('layouts.master')
@section('content')
    <div class="page appointment-category-index py-5">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <livewire:isite::items-list
                            moduleName="Iappointment"
                            itemComponentName="isite::item-list"
                            itemLayout="item-list-layout-1"
                            entityName="Category"
                            :showTitle="false"
                            :responsiveTopContent="['mobile'=>false,'desktop'=>false]"
                            :itemComponentAttributes="[
                                'itemLayout' => 'item-list-layout-1',
                                'withViewMoreButton' => true,
                                'viewMoreButtonLabel' => 'Ir a Consulta',
                            ]"
                    />
                </div>
            </div>
        </div>
    </div>
    <style>
        .appointment-category-index .card-category {
            background-color: transparent !important;
            margin-bottom: 3rem;
        }
        .appointment-category-index .card-category .image-link {
            height: 0;
            padding-bottom: 56.25%;
            position: relative;
            display: block;
        }
        .appointment-category-index .card-category .image-link img {
            position: absolute;
            width: 100%;
            height: 100%;
            object-fit: cover;
            left: 0;
        }
        .appointment-category-index .card-category .item-category-title {
            display: none;
        }
        .appointment-category-index .card-category .title {
            font-size: 1.125rem;
            margin: 4px 15px 0;
            color: var(--secondary);
            font-weight: 600;
        }
        .appointment-category-index .card-category .summary {
            color: #555555;
            font-size: 0.875rem;
            margin-top: 0 !important;
        }
        .appointment-category-index .card-category .item-view-more-button .btn {
            font-size: 0.875rem;
            color: var(--warning);
            font-weight: bold;
            padding: 0 0 0 20px;
            position: relative;
            border-bottom: 2px solid;
            border-radius: 0;
        }
        .appointment-category-index .card-category .item-view-more-button .btn:hover {
            color: var(--primary);
        }
        .appointment-category-index .card-category .item-view-more-button .btn:focus {
            box-shadow: none !important;
        }
        .appointment-category-index .card-category .item-view-more-button .btn:before {
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            font-family: 'FontAwesome';
            content: "\f067";
        }

    </style>
@endsection
