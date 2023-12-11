<x-layout>
    <div class="ContentArea">
        <x-flash-message/>
        <x-back/>
        @if($manageableProjects->isNotEmpty())
            <div class="TextImage">
                <h2 class="TextImage--title  richtext">Manageable projects</h2>
            </div>
            <form class="Form js-Form" method="GET" id="Personal Data Edit" action="{{route('personal.update')}}">
                <div class="FormInput">
                    <label class="FormLabel" for="filter">
                        Filter
                    </label>
                    <div style="display: flex">
                        <input class="Input" name="filter" id="filter" value="{{ old('filter') }}">
                        <button class="Button color-primary size-large" type="submit" style="margin-left: 8px">
                        <span class="Button--inner">
                            Search
                        </span>
                        </button>
                    </div>
                </div>
            </form>
            <section class="ZoraPublications js-ZoraPublications">
                <ul class="ZoraPublications--list" data-level="1">
                    @foreach($manageableProjects as $project)
                        <li>
                            <a href="">
                                <div class="ZoraCitation">
                                    <span class="ZoraCitation--author">
                                        {{ $project->title }}
                                    </span>
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </section>
        @endif
        @if($memberProjects->isNotEmpty())
            <div class="TextImage">
                <h2 class="TextImage--title  richtext">View only projects</h2>
            </div>
            <form class="Form js-Form" method="GET" id="Personal Data Edit" action="{{route('personal.update')}}">
                <div class="FormInput">
                    <label class="FormLabel" for="filter">
                        Filter
                    </label>
                    <div style="display: flex">
                        <input class="Input" name="filter" id="filter" value="{{ old('filter') }}">
                        <button class="Button color-primary size-large" type="submit" style="margin-left: 8px">
                        <span class="Button--inner">
                            Search
                        </span>
                        </button>
                    </div>
                </div>
            </form>
            <ul class="ZoraPublications--list" data-level="1">
                @foreach($memberProjects as $project)
                    <li>
                        <a href="">
                            <div class="ZoraCitation">
                                <span class="ZoraCitation--author">
                                    @date($project->duration_start) &mdash; @date($project->duration_end)
                                </span>
                                <a class="Link">This is a link</a>
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif
        @if($manageableProjects->isEmpty() && $memberProjects->isEmpty())
            <div class="TextImage TextImage--inner Textimage--content richtext">
                <p>
                    There are no research projects under your name.
                </p>
            </div>
            <div class="TextImage">
                <a href="{{ route('research.create') }}" class="Button color-border-white size-large">
                    Create a new research project
                    <i class="fa fa-arrow-right" style="margin-left: 8px; vertical-align: bottom"></i>
                </a>
            </div>
        @endif
    </div>
</x-layout>
