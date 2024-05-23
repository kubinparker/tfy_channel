var download_video_button = $( '.download_video_file_button' );
download_video_button.click( () =>
{
    $.ajax( {
        url: '/get-and-save-videos',
        type: 'GET',
        dataType: 'json',
        success: resp => resp.success == 'ok' ? location.reload( true ) : false
    } );
} );


var write_file_json = $( '.write_file_json' );
write_file_json.click( () =>
{
    let textArea = $( '#resultTiktok' ).val();
    textArea = textArea.replace( /'/g, "" );
    $.ajax( {
        url: '/tiktok-datas',
        type: 'POST',
        data: {
            datas: JSON.parse( textArea ),
            _csrfToken: csrfToken
        },
        dataType: 'json',
        success: ( resp ) =>
        {
            if ( resp.success == 'ok' ) $( '#resultTiktok' ).val( '' );
        }
    } );
} );


var upload_video_button = $( '.upload_video_button' );
upload_video_button.click( () =>
{
    var upload_status = document.querySelector( '.upload_status' );
    var checkboxes = document.querySelectorAll( 'input[type="checkbox"]' );
    var checkedCheckboxes = Array.from( checkboxes ).filter( checkbox => checkbox.checked );
    var ids = checkedCheckboxes.map( e => e.value );
    // if ( ids.length === 0 )
    // {
    //     upload_status.classList.add( 'red' );
    //     upload_status.innerText = 'Chưa có video nào được chọn!';
    //     return false;
    // }
    upload_status.classList.remove( 'red' );
    upload_status.innerText = 'Đang thực hiện upload...';

    $.ajax( {
        url: '/upload-video',
        type: 'POST',
        data: {
            ids,
            _csrfToken: csrfToken
        },
        dataType: 'json',
        success: ( resp ) =>
        {
            if ( resp.success == 'ok' )
            {
                upload_status.classList.add( 'green' );
                upload_status.innerText = 'Upload Thành công!';
            }
            else
            {
                upload_status.classList.add( 'red' );
                upload_status.innerText = 'Upload Thất bại!';
            }
        }
    } );
} );


function showIMG ( e, id )
{
    $.ajax( {
        url: '/get-img',
        type: 'GET',
        data: { video_id: id },
        dataType: 'json',
        success: resp => resp.src ? e.src = resp.src : false
    } );
}