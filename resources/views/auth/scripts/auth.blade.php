<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script>
    $("#login_submit").click(function(e) {
        e.preventDefault();
        let _url = $('#login_form').attr('action');
        $.ajax({
            url: _url,
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            data: $('#login_form').serialize(),
            beforeSend: function() {
                mApp.blockPage({
                    overlayColor: "#000000",
                    type: "loader",
                    state: "primary",
                    message: "Mohon Tunggu..."
                });
            },
            success: function(data) {
                setTimeout(function() {
                    if (data && data.code && data.code == "-3") {
                        errorsHtml = "";
                        swal.fire("Error", data.info, "error");
                        mApp.unblockPage();
                    } else if (data && data.code && data.code == "00") {
                        swal.fire("Sukses", data.info, "success");
                        mApp.unblockPage();
                        setTimeout(function() {
                            window.location.href = data.data.url;
                        }, 1000);
                    } else {
                        swal.fire("Error", data.info, "error");
                        mApp.unblockPage();
                    }
                }, 100);
            },
            error: function(err) {
                if (err.status == 419) {
                    location.reload();
                }
                errorsHtml = '<div class=""><ul style="margin-bottom: 0px;">' +
                    '<strong>Something went wrong</strong>';
                errorsHtml += '</ul></div>';
                mApp.unblockPage();
            },
        });
    });
</script>
