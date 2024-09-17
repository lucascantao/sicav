<div class="overlay d-none">
    <div style="scale: 3; color: #05296b" class="spinner-border" role="status">
        <span class="sr-only"></span>
    </div>
</div>
<script>
    $('form').on('submit', function() {
        $('.overlay').removeClass('d-none');
        setTimeout(() => {
            $('.overlay').addClass('d-none');
        }, 8000);
    });
</script>