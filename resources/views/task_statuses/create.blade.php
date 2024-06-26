@extends('layouts.main')

@section('content')
    <section class="bg-white dark:bg-gray-900 text-black dark:text-white">
        <div class="grid max-w-screen-xl px-4 pt-20 pb-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12 lg:pt-28">
            <div class="grid col-span-full">
                <h1 class="mb-5 text-5xl">{{ __('layout.task_status.create') }}</h1>

                {{ Form::model($taskStatus, ['url' => route('task_statuses.store'), 'class' => 'w-50']) }}
                <div class="flex flex-col">
                    <div>
                        {{ Form::label('name', __('layout.task_status.name')) }}
                    </div>
                    <div class="mt-2 text-black">
                        {{ Form::text('name') }}
                    </div>
                    @if ($errors->first('name'))
                        <div class="text-red-500">
                            {{ $errors->first('name') }}
                        </div>
                    @endif
                    <div class="mt-2">
                        {{ Form::submit(__('layout.button.create'), ['class' => 'bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded']) }}
                        <a class='bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded'
                           href="{{ route('task_statuses.index')}}">{{ __('layout.button.back') }}</a>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </section>
@endsection
