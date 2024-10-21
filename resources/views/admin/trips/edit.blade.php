@extends('admin.layouts.mater')
@section('title')
    Cập nhật lại phân quyền
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Cập nhật lại phân quyền</h4>
            </div>
        </div>
    </div>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <div class="card">
        <form action="{{ route('admin.trips.update', $data) }}" method="POST" class="row g-3 p-5">
            @csrf
            @method('PUT')
            <div class="col-md-5">
                <label for="fullnameInput" class="form-label">Tuyến đường</label>
                <select class="form-select" aria-label="Default select example" name="route_id">
                    @foreach ($routes as $route)
                        <option value="{{ $route->id }}" {{ $route->id == $data->route_id ? 'selected' : '' }}>
                            {{ $route->route_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-5">
                <label for="fullnameInput" class="form-label">Xe</label>
                <select class="form-select" aria-label="Default select example" name="bus_id">
                    @foreach ($buses as $bus)
                    <option value="{{ $bus->id }}" {{ $bus->id == $data->bus_id ? 'selected' : '' }}>
                        {{ $bus->name_bus }} - {{ $bus->license_plate }}
                    </option>
                @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label for="exampleFormControlTextarea5" class="form-label">Thời gian khởi hành</label>
                <input type="text" class="form-control" name="departure_time" placeholder="hh:mm" id="cleave-time-format"
                    value="{{ $data->departure_time }}">
            </div>
            <div class="col-12">
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('admin.trips.index') }}" class="btn btn-success">Quay lại</a>
                </div>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/cleave.js@1.6.0/dist/cleave.min.js"></script>

    <!-- form masks init -->

    <script>
        var cleaveDate, cleaveDateFormat, cleaveTime, cleaveTimeFormat, cleaveNumeral, cleaveDelimiter, cleaveDelimiters,
            cleavePrefix, cleaveBlocks;
        document.querySelector("#cleave-date") && (cleaveDate = new Cleave("#cleave-date", {
            date: !0,
            delimiter: "-",
            datePattern: ["d", "m", "Y"]
        })), document.querySelector("#cleave-date-format") && (cleaveDateFormat = new Cleave("#cleave-date-format", {
            date: !0,
            datePattern: ["m", "y"]
        })), document.querySelector("#cleave-time") && (cleaveTime = new Cleave("#cleave-time", {
            time: !0,
            timePattern: ["h", "m", "s"]
        })), document.querySelector("#cleave-time-format") && (cleaveTimeFormat = new Cleave("#cleave-time-format", {
            time: !0,
            timePattern: ["h", "m"]
        })), document.querySelector("#cleave-numeral") && (cleaveNumeral = new Cleave("#cleave-numeral", {
            numeral: !0,
            numeralThousandsGroupStyle: "thousand"
        })), document.querySelector("#cleave-ccard") && (cleaveBlocks = new Cleave("#cleave-ccard", {
            blocks: [4, 4, 4, 4],
            uppercase: !0
        })), document.querySelector("#cleave-delimiter") && (cleaveDelimiter = new Cleave("#cleave-delimiter", {
            delimiter: "·",
            blocks: [3, 3, 3],
            uppercase: !0
        })), document.querySelector("#cleave-delimiters") && (cleaveDelimiters = new Cleave("#cleave-delimiters", {
            delimiters: [".", ".", "-"],
            blocks: [3, 3, 3, 2],
            uppercase: !0
        })), document.querySelector("#cleave-prefix") && (cleavePrefix = new Cleave("#cleave-prefix", {
            prefix: "PREFIX",
            delimiter: "-",
            blocks: [6, 4, 4, 4],
            uppercase: !0
        })), document.querySelector("#cleave-phone") && (cleaveBlocks = new Cleave("#cleave-phone", {
            delimiters: ["(", ")", "-"],
            blocks: [0, 3, 3, 4]
        }));
    </script>
@endsection
