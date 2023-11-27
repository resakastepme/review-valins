@foreach ($post as $p)
    <div class="card m-5 rounded shadow border-4">
        <div class="card-header">

            <div class="row align-items-center justify-content-center">
                <div class="col-12 col-md-auto text-center mb-4 mb-md-0">
                    <i class="fa-solid fa-user fa-2xl" style="font-size: 100px;"></i>
                </div>
                <div class="col-12 col-md-6">
                    <div class="d-flex align-items-center mb-3">
                        <p class="mb-0" style="font-weight: bold">Tugas Dari:</p>
                        <p class="mb-0 ml-2 ms-2" style="font-style: italic">
                            {{ $p->getUsers->username }}</p>
                        <!-- Hide on mobile devices -->
                        <p class="mb-0 ml-md-5 d-none d-md-block ms-5" style="font-weight: bold">
                            Reviewer:</p>
                        <p class="mb-0 ml-2 d-none d-md-block ms-2" style="font-style: italic">
                            {{ $p->getReviewers->username }}</p>
                        <p class="mb-0 ml-md-5 d-none d-md-block ms-5" style="font-weight: bold">
                            Tanggal:</p>
                        <p class="mb-0 ml-2 d-none d-md-block ms-2" style="font-style: italic">
                            {{ \Carbon\Carbon::parse($p->created_at)->format('Y-m-d') }}</p>
                    </div>
                    <!-- Show on mobile devices only -->
                    <div class="d-md-none mb-3 d-flex">
                        <p class="mb-0" style="font-weight: bold">Reviewer:</p>
                        <p class="mb-0 ml-2 ms-2" style="font-style: italic">
                            {{ $p->getReviewers->username }}</p>
                    </div>
                    <div class="d-md-none mb-3 d-flex">
                        <p class="mb-0" style="font-weight: bold">Tanggal:</p>
                        <p class="mb-0 ml-2 ms-2" style="font-style: italic">
                            {{ \Carbon\Carbon::parse($p->created_at)->format('Y-m-d') }}</p>
                    </div>
                    <p style="font-weight: bold" class="mt-3">Komentar</p>
                    <textarea class="form-control" rows="3" readonly>{{ $p->komentar }}</textarea>
                </div>
                <div class="col-12 col-md-2">
                    <div class="d-md-none mb-3 d-flex mt-3">
                        <p class="mb-0" style="font-weight: bold">Total data:</p>
                        <p class="mb-0 ml-2 ms-2">
                            {{ \App\Models\Data::where('id_reviewer', $p->id_reviewer)->count() }}
                        </p>
                    </div>
                    <div class="d-md-none mb-3 d-flex">
                        <p class="mb-0" style="font-weight: bold">Selesai:</p>
                        <p class="mb-0 ml-2 ms-2" style="color: green">
                            {{ \App\Models\Reviewer::where('id_assignments', $p->id)->where('finish', 1)->count() }}
                        </p>
                    </div>
                    <div class="d-md-none mb-3 d-flex">
                        <p class="mb-0" style="font-weight: bold">Status:</p>
                        <p class="mb-0 ml-2 ms-2"
                            style="font-style: italic; {{ \App\Models\Reviewer::where('id_assignments', $p->id)->where('finish', 1)->count() == 0? 'color: rgb(213, 157, 59);': 'color: green;' }}">
                            {{ \App\Models\Reviewer::where('id_assignments', $p->id)->where('finish', 1)->count() == 0? 'Belum selesai': 'Selesai' }}
                        </p>
                    </div>
                    <div class="d-none d-md-block">
                        <p class="mb-0" style="font-weight: bold">Total data:</p>
                        <p class="mb-0 ml-2 ms-2">
                            {{ \App\Models\Data::where('id_reviewer', $p->id_reviewer)->count() }}
                        </p>
                        <p class="mb-0" style="font-weight: bold">Selesai:</p>
                        <p class="mb-0 ml-2 ms-2" style="color: green">
                            {{ \App\Models\Reviewer::where('id_assignments', $p->id)->where('finish', 1)->count() }}
                        </p>
                        <p class="mb-0" style="font-weight: bold">Status:</p>
                        <p class="mb-0 ml-2 ms-2"
                            style="font-style: italic; {{ \App\Models\Reviewer::where('id_assignments', $p->id)->where('finish', 1)->count() == 0? 'color: rgb(213, 157, 59);': 'color: green;' }}">
                            {{ \App\Models\Reviewer::where('id_assignments', $p->id)->where('finish', 1)->count() == 0? 'Belum selesai': 'Selesai' }}
                        </p>
                    </div>
                </div>
                <div class="col-12 col-md-2">
                    <div class="d-flex justify-content-center align-items-center">
                        <button class="btn btn-secondary"> <i class="fa-solid fa-eye"></i></button>
                        <button class="btn btn-primary ms-2"> <i class="fa-solid fa-pen-to-square"></i></button>
                        <button class="btn btn-danger ms-2"> <i class="fa-solid fa-trash"></i></button>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endforeach
