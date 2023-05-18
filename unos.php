<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Unos vijesti ili proizvoda</title>
  <link rel="stylesheet" type="text/css" href="newStyle.css">
  <script type="text/javascript" src="jquery-1.11.0.js"></script>
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
   <script src="js/form-validation.js"></script> 
   
</head>
<body>

<script>
        $(function() {
            $("form[name='unos']").validate({
                rules: {
                    title: {
                        required: true,
                        minlength: 5,
                        maxlength: 30,
                    },
                    about: {
                        required: true,
                        minlength: 10,
                        maxlength: 50,
                    },
                    content: {
                        required: true,
                    },
                    picture: {
                      required: true,
                    }

                },
                messages: {
                    title: {
                        required: "Naslov ne smije biti prazan",
                        minlength: "Naslov treba imati više od 6 znakova",
                        maxlength: "Naslov treba imati manje od 30 znakova",
                    },
                    about: {
                        required: "Potrebno je upisati kratki sadrzaj",
                        minlength: "Kratki sadrzaj ne smije biti kraci od 10 znakova",
                        maxLength: "Kratki sadrzaj ne smije biti duzi od 50 znakova",
                    },
                    content: {
                        required: "Potrebno je upisati sadrzaj",
                    },
                    picture: {
                        required: "Potrebno je uploadati sliku",
                    },
                },
                highlight: function(element) {
                    $(element).next().addClass("error");
                },
                unhighlight: function(element) {
                    $(element).next().removeClass("error");
                },
                errorPlacement: function(error, element) {
                    error.addClass("error-message");
                    error.insertAfter(element);
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });
        });
    </script>
  <main>
    <h1 class="naslov">Unos vijesti</h1>
    <form name="unos" action="handleNewNews.php" method="POST" enctype="multipart/form-data" class="form-news"> 
      <div class="form-item"> 
        <label for="title">Naslov vijesti</label> 
        <div class="form-field"> 
          <input type="text" name="title" id="title" class="form-field-textual"> 
        </div> 
      </div> 
      <div class="form-item"> 
        <span id="porukaAbout" class="bojaPoruke"></span>
        <label for="about">Kratki sadržaj vijesti (do 50 znakova)</label> 
        <div class="form-field"> 
          <textarea name="about" id="about" cols="30" rows="10" class="form-field-textual"></textarea> 
        </div> 
      </div> 
      <div class="form-item">
        <label for="content">Sadržaj vijesti</label> 
        <div class="form-field"> 
          <textarea name="content" id="content" cols="30" rows="10" class="form-field-textual"></textarea> 
        </div> 
      </div> 
      <div class="form-item">
        <label for="pphoto">Slika: </label> 
        <div class="form-field"> 
          <input type="file" accept="image/jpg,image/gif,image/png,image/jpeg" class="input-text" name="picture" id="picture"/> 
        </div> 
      </div> 
      <div class="form-item">
        <label for="category">Kategorija vijesti</label>
      <div class="form-field"> 
        <select name="category" id="" class="form-field-textual"> 
          <option value="0">Sport</option> 
          <option value="1">Politik</option> 
        </select> 
      </div> 
    </div> 
      <div class="form-item"> 
      <label>Spremiti u arhivu: 
      <div class="form-field"> 
        <input type="checkbox" name="archive"> 
      </div> 
    </label> 
    </div> 
    <div class="form-item"> 
      <button type="reset" value="Poništi">Poništi</button> 
      <button type="submit" value="Prihvati" id="slanje">Prihvati</button> 
    </div> 
    </form>
  </main>


</body>
</html>
