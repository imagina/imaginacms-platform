@extends('layouts.master')
@section('content')
  <x-isite::breadcrumb>
    @if(isset($category))
      <li class="breadcrumb-item">
        <a href="{{ route(locale().'.iplan.plan.index') }}">{{ trans('iplan::plans.title.breadcrumb') }}</a>
      </li>
    @endif
    <li class="breadcrumb-item active"
        aria-current="page"> {{ isset($category) ? $category->title : trans('iplan::plans.title.breadcrumb') }}</li>
  </x-isite::breadcrumb>
  <div class="container">
    @if($errors->any())
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {!! $errors->first() !!}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    @endif
    <div class="py-3">
      @php
        $params = [];
        if(isset($category)){
            $params = [
                'filter' =>[
                    'category' => "$category->id"
                ]
            ];
        }

        // Hide plan default
        if(setting('iplan::hideDefaultPlanInView',null,false)){
          $defaultPlanId = (int)setting('iplan::defaultPlanToNewUsers',null,0);
          if(!is_null($defaultPlanId) && $defaultPlanId!=0){

            $filter['exclude'] = $defaultPlanId;

            if(isset($params['filter']))
              array_merge($params['filter'],$filter);
            else
              $params['filter'] = $filter;
            
          }
        }
      @endphp
      <x-isite::carousel.owl-carousel
              id="carouselPlans"
              repository="Modules\Iplan\Repositories\PlanRepository"
              itemComponentNamespace="Modules\Iplan\View\Components\PlanListItem"
              itemComponent="iplan::plan-list-item"
              :loop="false"
                    :nav="false"
              :margin="0"
              :params="$params"
              :responsive="[
                      '0' => [
                        'items' => 1,
                      ],
                      '560' => [
                        'items' => 2,
                      ],
                      '1024' => [
                        'items' => 3
                      ]
                    ]"
      />
    </div>
  </div>

  <style>
    #carouselPlans .card-plan .nav {
      margin-bottom: -3px;
      margin-left: 5px;
      margin-right: 5px;
    }
    #carouselPlans .card-plan .nav .nav-item {
      position: relative;
    }
    #carouselPlans .card-plan .nav .nav-item .percent {
      position: absolute;
      width: 100%;
      top: -10px;
      text-align: center;
      left: 0;
      padding: 0 1px;
      font-size: 0.813rem;
      font-family: 'Poppins', sans-serif;
    }
    #carouselPlans .card-plan .nav .nav-item .nav-link {
      border-color: #B4B4B4 #B4B4B4 #fff;
      background-color: #fff;
      font-size: 0.75rem;
      color: #777777;
      margin: 10px 1px 0;
    }
    #carouselPlans .card-plan .nav .nav-item .nav-link.active {
      padding-top: 12px;
      padding-bottom: 12px;
      background-color: var(--primary);
      color: #fff;
      border-color: var(--primary) var(--primary) #fff;
      margin: 0 1px;
    }
    #carouselPlans .card-plan .nav .nav-item .nav-link.active .percent {
      top: -20px;
    }
    #carouselPlans .card-plan .card-header {
      background-color: #fff;
      box-shadow: 2px 2px 1rem rgba(0, 0, 0, 0.15);
      position: relative;
    }
    #carouselPlans .card-plan .card-header .desc {
      background-color: var(--secondary);
      color: #fff;
      position: absolute;
      top: 10px;
      right: 10px;
      width: 50px;
      height: 50px;
      font-family: 'Poppins', sans-serif;
      font-size: 0.563rem;
    }
    #carouselPlans .card-plan .card-header .desc .num {
      font-size: 0.813rem;
    }
    #carouselPlans .card-plan .card-header .desc > div {
      padding: 8px 0;
    }
    #carouselPlans .card-plan .card-header .config {
      font-family: 'Poppins', sans-serif;
      font-size: 0.938rem;
      font-weight: bold;
    }
    #carouselPlans .card-plan .card-header .title {
      font-family: 'Poppins', sans-serif;
      font-size: 2.438rem;
      font-weight: bold;
    }
    #carouselPlans .card-plan .card-header .price {
      font-size: 1.625rem;
      font-weight: bold;
      color: var(--primary);
    }
    #carouselPlans .card-plan .card-header .price del {
      font-size: 1.125rem;
    }
    #carouselPlans .card-plan .card-header .subtitle {
      font-size: 1rem;
      color: #878787;
    }
    #carouselPlans .card-plan .card-frame {
      box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
      margin: 0 5px;
    }
    #carouselPlans .card-plan .card-frame ul {
      font-size: 1rem;
      list-style: none;
      padding-left: 1rem !important;
    }
    #carouselPlans .card-plan .card-frame ul li {
      border: 0;
      padding: 0.5rem 1.25rem 0.5rem 25px;
      position: relative;
    }
    #carouselPlans .card-plan .card-frame ul li:before {
      content: "\f00c";
      font-family: FontAwesome;
      font-weight: bold;
      top: 7px;
      left: 0;
      position: absolute;
      color: var(--primary);
    }
    #carouselPlans .card-plan .card-frame .btn {
      font-family: 'Poppins', sans-serif;
      font-size: 0.938rem;
      margin-bottom: -20px;
      padding: 10px 25px;
    }
    #carouselPlans .card-plan .card-header.bg-primary {
      transition: 0.3s;
      background-color: var(--primary);
    }
    #carouselPlans .card-plan .card-header.bg-primary .desc {
      background-color: #fff;
      color: var(--primary);
    }
    #carouselPlans .card-plan .card-header.bg-primary .title, #carouselPlans .card-plan .card-header.bg-primary .price, #carouselPlans .card-plan .card-header.bg-primary .subtitle {
      color: #fff;
    }
    #carouselPlans .card-plan:hover .card-header {
      transition: 0.3s;
      background-color: var(--primary);
    }
    #carouselPlans .card-plan:hover .card-header .desc {
      background-color: #fff;
      color: var(--primary);
    }
    #carouselPlans .card-plan:hover .card-header .title, #carouselPlans .card-plan:hover .card-header .price, #carouselPlans .card-plan:hover .card-header .subtitle {
      color: #fff;
    }
    @media (max-width: 575.98px) {
      #carouselPlans .card-plan .nav .nav-item .nav-link {
        font-size: 0.625rem;
      }
      #carouselPlans .card-plan .card-header .title {
        font-size: 1.563rem;
      }
      #carouselPlans .card-plan .card-header .price {
        font-size: 1.25rem;
      }
      #carouselPlans .card-plan .card-header .subtitle {
        font-size: 0.875rem;
      }
      #carouselPlans .card-plan .card-frame .list-group {
        font-size: 0.875rem;
      }
    }

  </style>
@endsection
