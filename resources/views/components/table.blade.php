
<div class="table-responsive">
    <table id="datatables" {{ $attributes->merge(['class' => 'table table-striped table-bordered text-nowrap w-100']) }}>
        @isset($thead)
            <thead>
                {{ $thead }}
            </thead>
        @endisset
        
        <tbody>
            {{ $slot }}
        </tbody>
    </table>
</div>