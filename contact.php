<?php include("components/header.php");?>
    <section class="container addSpace">
        <div class="row">
            <div class="col-md-12">
                <h1 class="title">Contact US</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <form  method="post" action="mailto:info@sportstore.com" enctype="text/plain">
                <div class="form-group">
                    <label for="firstName">First Name</label>
                    <input type="text" class="form-control" id="firstName" placeholder="Your first name...">
                </div>
                <div class="form-group">
                    <label for="lastName">Last Name</label>
                    <input type="text" class="form-control" id="lastName" placeholder="Your last name...">
                </div>
                <div class="form-group">
                    <label for="firstName">First Name</label>
                    <input type="text" class="form-control" id="firstName" placeholder="Password">
                </div>
                <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Your E-mail address...">
                    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                </div>
                <div class="form-group">
                    <label for="subject">Subject</label>
                    <textarea id="subject" name="subject" placeholder="Write something..." class="form-control" rows="8"></textarea>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-danger btn-block">Submit</button>
                </div>
                </form>
            </div>
        </div>
    </section>
<?php include("components/footer.php");?>