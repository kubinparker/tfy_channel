<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Shop Homepage - Start Bootstrap Template</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styles.css" rel="stylesheet" />
    <link href="css/home.css" rel="stylesheet" />
    <?= $this->Html->scriptBlock(sprintf(
        'var csrfToken = %s;',
        json_encode($this->request->getAttribute('csrfToken'))
    )); ?>
</head>

<body>

    <!-- Section-->
    <section>
        <div class="px-4 px-lg-5 mt-2">
            <div class="row">
                <div class="col-7">
                    <div class="row">

                        <?php foreach ($lists as $item) : ?>
                            <?php if (strpos('.', $item) !== false || strpos('..', $item) !== false || !is_file(WWW_ROOT . 'videos/movies/' . $item . '/' . $item . '.mp4')) continue; ?>
                            <div class="col mb-5">
                                <div class="card h-100">
                                    <!-- Product image-->
                                    <!-- <video class="card-img-top" controls>
                                        <source src="<?= '/videos/movies/' . $item ?>" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video> -->
                                    <?php $item = str_replace('.mp4', '', $item); ?>
                                    <!-- <img class="card-img-top" onclick="showIMG(this,'<?= $item ?>')" src="https://dummyimage.com/450x300/dee2e6/6c757d.jpg" alt="..." /> -->
                                    <img class="card-img-top" src="<?= '/videos/movies/' . $item . '/' . $item . '.gif' ?>" alt="..." />
                                    <!-- Product actions-->
                                    <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                        <div class="text-center">
                                            <input type="checkbox" name="ids[]" value="<?= $item ?>" id="<?= $item ?>">
                                            <label class="btn btn-outline-dark mt-auto" for="<?= $item ?>">Add to cart</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php endforeach ?>
                    </div>
                </div>
                <div class="col-5">
                    <div class="input-group input-group-sm mb-3">
                        <span class="input-group-text" id="inputGroup-sizing-sm">Key Search: #</span>
                        <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" placeholder="a-zA-Z0-9">
                        <button class="btn btn-outline-secondary" type="button" id="button-addon2">Get Link</button>
                    </div>
                    <div class="card border-secondary mb-3">
                        <div class="card-body text-secondary">
                            <p class="card-text">
                                <a class="btn btn-primary mb-1" data-href="https://www.tiktok.com">#Some</a>
                                <a class="btn btn-primary mb-1" data-href="https://www.tiktok.com">#quick</a>
                                <a class="btn btn-primary mb-1" data-href="https://www.tiktok.com">#example</a>
                                <a class="btn btn-primary mb-1" data-href="https://www.tiktok.com">#text</a>
                                <a class="btn btn-primary mb-1" data-href="https://www.tiktok.com">#to</a>
                                <a class="btn btn-primary mb-1" data-href="https://www.tiktok.com">#build</a>
                                <a class="btn btn-primary mb-1" data-href="https://www.tiktok.com">#on</a>
                                <a class="btn btn-primary mb-1" data-href="https://www.tiktok.com">#the</a>
                                <a class="btn btn-primary mb-1" data-href="https://www.tiktok.com">#card</a>
                                <a class="btn btn-primary mb-1" data-href="https://www.tiktok.com">#title</a>
                                <a class="btn btn-primary mb-1" data-href="https://www.tiktok.com">#and</a>
                                <a class="btn btn-primary mb-1" data-href="https://www.tiktok.com">#make</a>
                                <a class="btn btn-primary mb-1" data-href="https://www.tiktok.com">#up</a>
                                <a class="btn btn-primary mb-1" data-href="https://www.tiktok.com">#the</a>
                                <a class="btn btn-primary mb-1" data-href="https://www.tiktok.com">#bulk</a>
                                <a class="btn btn-primary mb-1" data-href="https://www.tiktok.com">#of</a>
                                <a class="btn btn-primary mb-1" data-href="https://www.tiktok.com">#the</a>
                                <a class="btn btn-primary mb-1" data-href="https://www.tiktok.com">#card's</a>
                                <a class="btn btn-primary mb-1" data-href="https://www.tiktok.com">#content</a>
                            </p>
                        </div>
                    </div>
                    <p><a class="link-opacity-75-hover" target="_blank" href="https://www.tiktok.com/search/video?q=">https://www.tiktok.com/search/video?q=quynh+nga</a></p>
                    <div class="card border-secondary mb-3">
                        <div class="card-body text-secondary">
                            <pre class="mb-0 code">
<code>
    /**
    *  * nếu ở trang tìm kiếm thì chọn tab Top *
    * mở console và nhập vào các lệnh bên dưới
    */

    var __data__ = document.querySelector( '#SIGI_STATE' )? ( JSON.parse( document.querySelector( '#SIGI_STATE' ).text ) ).ItemModule : false;
    var _data_ = [];

    if ( !__data__ )
    {
        // var boxSearch = document.querySelectorAll( '.tiktok-1soki6-DivItemContainerForSearch' );
        var boxSearch = document.querySelectorAll( '.e19c29qe10' );
        boxSearch.forEach( e =>
        {
            const ec2 = e.querySelector( 'div[data-e2e="search_top-item"]' );
            let ahref = ec2.querySelector( 'a' ).href;
            ahref = ahref.replace( 'https://www.tiktok.com/@', '' );
            const [ author, v, id ] = ahref.split( '/' );
            var result = { author, id, desc: '' };

            const hashtags = e.querySelectorAll( 'a[data-e2e="search-common-link"]' );
            hashtags.forEach( e2 =>
            {
                let a2href = e2.getAttribute( 'href' );
                const [ _, t, hashtag ] = a2href.split( '/' );
                result.desc += ` #${ hashtag }`;
            } )

            _data_.push( result );
        } );

    } else
    {
        _data_ = ( Object.values( __data__ ) ).map( dt => ( { author: dt.author, id: dt.id, desc: dt.desc } ) );
    }

    _data_ = JSON.stringify( _data_ );

    _data_
    /***
    * Sau khi có kết quả được in ra 
    * bước 1: copy kết quả và dán vào ô textarea bên dưới 
    * bước 2: bấm "Ghi file JSON"
    */
</code>
                            </pre>
                        </div>
                    </div>
                    <div class="card border-secondary mb-3">
                        <div class="card-body text-secondary">
                            <div class="form-floating">
                                <textarea class="form-control" placeholder="Leave a comment here" id="resultTiktok" style="height: 100px"></textarea>
                                <label for="resultTiktok">Dán kết quả từ console của Tiktok vào đây !!!</label>
                            </div>
                            <div class="text-center mt-3">
                                <button type="button" class="btn btn-secondary write_file_json">Ghi file JSON</button>
                            </div>
                        </div>
                    </div>
                    <p><a class="link-opacity-75-hover" target="_blank" href="https://savetiktok.io/">https://savetiktok.io/</a></p>
                    <div class="card border-secondary mb-3">
                        <div class="card-body text-secondary">
                            <pre class="mb-0 code">
<code>
    /**
    * mở command line của visualstudio code lên 
    * chạy file downloadTT.py bằng pyhton để download video về máy
    * 
    * Hoặc
    * 
    * vào trang https://savetiktok.io 
    * mở console và nhập vào các lệnh bên dưới
    */
    async function fetchData ( url )
    {
        const response = await fetch( "https://savetiktok.io/api/video-info", {
            method: "POST",
            body: JSON.stringify( {
                url: url,
            } ),
            headers: {
                "Content-type": "application/json; charset=UTF-8"
            }
        } );
        const data = await response.json();
        return data;
    }

    async function sleep ( ms )
    {
        return new Promise( resolve => setTimeout( resolve, ms ) );
    }

    async function processRequests ( urls, delay )
    {
        var dt = [];
        for ( const url of urls )
        {
            const result = await fetchData( url );
            dt.push( result );
            await sleep( delay );
        }
        return dt;
    }

    fetch( 'http://local.tfy-chan.loca/?get_list_data_video=1' ).then( r => r.json() ).then( async ( d ) =>
    {
        const urls = d.data.map( v => `https://www.tiktok.com/@${ v.author }/video/${ v.id }` );
        var videos = await processRequests( urls, 10000 );

        // trả video về file _index.php
        var formData = new FormData();
        formData.append( 'videos', JSON.stringify( videos ) );
        const options = {
            method: 'POST',
            body: formData
        };
        fetch( 'http://local.tfy-chan.loca/save-tiktok-datas', options ).then( ( res ) => res.json() ).then( data => console.log( data.success ) );
    } );
</code>
                            </pre>
                        </div>
                    </div>

                    <div class="text-center">
                        <button type="button" class="btn btn-secondary download_video_file_button">Download Video File</button>
                    </div>
                    <br>
                    <p class="upload_status"></p>
                    <div class="text-center">
                        <button type="button" class="btn btn-secondary upload_video_button">Upload Video</button>
                    </div>


                </div>
            </div>
        </div>
    </section>

    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
</body>

</html>