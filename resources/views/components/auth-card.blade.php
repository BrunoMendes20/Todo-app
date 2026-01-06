<div class='container mb-5 d-flex justify-content-center align-items-center'>
    <div class="col-md-6 col-sm-8">
        <div class="card p-5 d-flex flex-column">

            <div class="row mt-5 justify-content-center">
                <div class="col-md-10 col-12">
                    {{ $slot ?? null }}

                </div>

            </div>
            <p class="footer text-center mt-auto">
                {{ $footer ?? null }}
            </p>
        </div>

    </div>

</div>
