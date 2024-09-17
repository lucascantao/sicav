<div class="modal-delete d-none">
    <div class="bg-white card p-4">
        <p id='msg' class="fs-5"></p>
        <div>
            <a id="modal-delete-href" class="col-3 btn btn-outline-danger me-4 mt-3" href="">Sim</a>
            <a class="cancel col-3 btn btn-outline-semas mt-3">Não</a>
        </div>
    </div>
</div>

<script>
    function modalDelete(arr) {
        id = arr['id'];
        message = arr['message'];
        route = arr['route']

        $('#msg').text(message);
        $('#modal-delete-href').attr('href', route);
        $('.modal-delete').removeClass('d-none');
    }

    $('.modal-delete .cancel').on('click', function() {
        $('.modal-delete').addClass('d-none')
    })
</script>
