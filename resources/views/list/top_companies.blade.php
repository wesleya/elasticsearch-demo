<div class="list-group">

    @foreach ($companies as $company)
        <div class="complaint-card">
            <a class="list-group-item flex-column align-items-start">
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1 font-weight-normal">{{$loop->index + 1}}. {{$company->company}}</h5>
                </div>
                <small>{{$company->count}} complaints</small>
            </a>
        </div>
    @endforeach

</div>