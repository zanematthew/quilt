jQuery( document ).ready(function( $ ){

    $('.button-restore-default').on('click', function( e ){

        r = confirm( _quilt.restore_default_message );

        if ( r == true){

            var $this = $(this);

            $.ajax({
                url: ajaxurl,
                dataType: 'json',
                type: 'POST',
                data: {
                    action: 'restoreDefaultsAjax',
                    namespace: $this.data('namespace'),
                    _wpnonce: $this.data('quilt_restore_default_nonce')
                },
                success: function( msg ){
                    location.reload();
                }
            });

        }

    });

});