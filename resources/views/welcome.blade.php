@extends('layouts.master')

@section('title')
    Welcome to FastFoodGuru!
@endsection

@section('content')
    <div class="container">
        @if(count($errors) > 0)
        <ul>
            @foreach ($errors->all() as $error)
                <div class="alert alert-dismissible alert-warning">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <h4>Error</h4>
                        <p>{{ $error }}</p>
                    </div>
            @endforeach
        </ul>
        @endif
        <h2>Search</h2>

        {{-- Form returns original page --}}
        <div class="panel panel-primary">
          <div class="panel-heading">
            <h3 class="panel-title">Find a fast food restaurant</h3>
          </div>
          <div class="panel-body">
              <form method='GET' action='/'>
                  <div class="form-group">
                      <label for='searchTerm'>Chain:</label>
                      <select class="form-control" name=searchTerm id=searchTerm>
                          @if($searchTerm)
                              <option value={{ $searchTerm }}>Select a different restaurant</option>
                          @else
                              <option value="">Select a restaurant (Required)</option>
                          @endif
                          <option>McDonald's</option>
                          <option value="burger+king">Burger King</option>
                          <option>KFC</option>
                          <option value="Boloco">Boloco</option>
                          <option>Subway</option>
                          <option value="dunkin+donuts">Dunkin Donuts</option>
                          </select>

                          <input type="checkbox" name="openNow" value="openNow"
                            {{ $openNow ? 'checked' : ''}}>Open Now

                      <p><label for="limit">Limit # of results to </label>
                        <input type="text" name="limit" id=limit value={{ is_numeric($limit) ? $limit : ''}}></p>
                  </div>
                  <input type='submit' class='btn btn-primary btn-small'>
              </form>
          </div>
        </div>
    </div>

    {{-- Testing location method --}}
    {{-- @if($position)
        {{ dump($position->latitude) }}
        {{ dump($position->longitude) }}
    @endif --}}

    @if($searchTerm)
        {{-- {{ dump($searchTerm) }}
        {{ $searchResultsURL }}
        {{ dump($searchResultsArray) }} --}}
    <div class="container">
        <ul class="list-group">
            @if ($openNow)
                @foreach (array_slice($searchResultsArray["results"], 0, $limit) as $restaurant)
                    @if($restaurant["opening_hours"]["open_now"] == true)
                        <li class="list-group-item">
                            @if($restaurant["opening_hours"]["open_now"] == true)
                                <span class="label label-success">Open Now</span>
                            @else
                                <span class="label label-danger">Closed Now</span>
                            @endif
                            <h4>{{ $restaurant["formatted_address"] }}</h4>
                            <p>{{ $restaurant["name"] }}</p>
                            <a href="#info{{ $restaurant["id"] }}" class="btn btn-info" data-toggle="collapse">Show reviews</a>
                            <div id="info{{ $restaurant["id"] }}" class="collapse">
                                No reviews yet! <a href="/restaurant/{{ $restaurant["id"] }}"">Add a review?</a>
                            </div>
                        </li>
                    @endif
                @endforeach
            @else
                @foreach ($searchResultsArray["results"] as $restaurant)
                    <li class="list-group-item">
                        @if($restaurant["opening_hours"]["open_now"] == true)
                            <span class="label label-success">Open Now</span>
                        @else
                            <span class="label label-danger">Closed Now</span>
                        @endif
                        <h4>{{ $restaurant["formatted_address"] }}</h4>
                        <p>{{ $restaurant["name"] }}</p>
                        <a href="#info{{ $restaurant["id"] }}" class="btn btn-info" data-toggle="collapse">Show reviews</a>
                        <div id="info{{ $restaurant["id"] }}" class="collapse">
                            No reviews yet! <a href="/restaurant/{{ $restaurant["id"] }}"">Add a review?</a>
                        </div>
                    </li>
                @endforeach
            @endif
        </ul>
    </div>
    @endif

@endsection
