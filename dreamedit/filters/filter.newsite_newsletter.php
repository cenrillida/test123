<div class="row justify-content-center">
    <div class="col-6 text-center">
        <div id="newsletter_message"></div>
        <form id="newsletter" action="/newsletter_request.php" method="get">
            <div class="form-group">
                <label for="exampleInputEmail1">Введите Ваш e-mail</label>
                <input type="email" class="form-control" id="newsletter_email" aria-describedby="emailHelp" name="email" placeholder="example@example.com">
                <small id="emailHelp" class="form-text text-muted"></small>
            </div>
            <input type="submit" value="Подписаться" class="btn btn-lg imemo-button text-uppercase">
        </form>
    </div>
</div>