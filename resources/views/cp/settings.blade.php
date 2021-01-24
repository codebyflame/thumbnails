@extends('statamic::layout')

@section('content')
    <publish-form
        title="Thumbnail Settings"
        action="{{ cp_route('thumbnails.settings') }}"
        :blueprint='@json($blueprint)'
        :meta='@json($meta)'
        :values='@json($values)'
    ></publish-form>

    <div class="thumbnails-preview">

        <h2>Preview</h2>
        <p>This is what a collection item would look like if you shared it on social media.</p>

        <div class="thumbnails-social-cards">
            <div class="thumbnails-social-cards--card-twitter thumbnails-social-cards--card">
                <div class="thumbnails-social-cards--card-image" data-url="{{ url('/thumbnails/demo') }}">
                    <img src="{{ url('/thumbnails/demo') }}">
                </div>
                <div class="thumbnails-social-cards--card-content">
                    <h3>Lorem ipsum dolor sit amet</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit...</p>
                    <div class="website">website.com</div>
                </div>
            </div>

            <div class="thumbnails-social-cards--card-facebook thumbnails-social-cards--card">
                <div class="thumbnails-social-cards--card-image" data-url="{{  url('/thumbnails/demo') }}">
                    <img src="{{ url('/thumbnails/demo') }}">
                </div>
                <div class="thumbnails-social-cards--card-content">
                    <div class="website">website.com</div>
                    <h3>Lorem ipsum dolor sit amet</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit...</p>
                </div>
            </div>
        </div>

    </div>
@stop
