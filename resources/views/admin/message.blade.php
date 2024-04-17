@if (Session::has('success'))
    <div style="background-color: #b6e4c1;" class="alert alert-success" id="success-alert" role="alert">
        Success! {{ Session::get('success') }}
    </div>
@endif

@if (Session::has('error'))
    <div class="alert alert-danger" id="danger-alert" role="alert">
        Error! {{ Session::get('error') }}
    </div>
@endif

<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
        window.setTimeout(function() {
            $("#success-alert").alert('close');
        }, 5000);

        window.setTimeout(function() {
            $("#danger-alert").alert('close');
        }, 5000);
    });
</script>
