var formSubmit = document.getElementById("formSubmit");
var input = document.getElementById("search-text");
var search = document.getElementById("search");
var paragraphs = document.getElementsByTagName("p");

function getInput(event) {
    event.preventDefault();
    var inputValue = input.value.toLowerCase();
    findParagraph(inputValue);
    findWord(inputValue);
}

formSubmit.addEventListener("submit",getInput);

function findParagraph(inputValue) {
    removeBackground();
    for (i = 0; i < paragraphs.length; i++) {
        if (paragraphs[i].innerHTML.toLowerCase().indexOf(inputValue) >= 0) {
            paragraphs[i].classList.add("found");
        }
    }
}

function removeBackground() {
  for (i = 0; i < paragraphs.length; i++) {
    paragraphs[i].classList.remove("found");
  }
}

function findWord(inputValue) {
    for (i =0; i < paragraphs.length; i++) {
        var content = paragraphs[i].innerHTML;
        inputValue = inputValue.replace(/[.*+?^&()|${}|[\]\\]/g,'\\$&');
        var myRegExp = new RegExp(inputValue,'g');
        var m;

        if (inputValue.length > 0) {
            paragraphs[i].innerHTML = content.replace(myRegExp, `<mark>$&</mark>`);
        }else {
            paragraphs[i].innerHTML = content;
        }
    }
}

$('#contact-form').validate({
    submitHandler: function (form) {

        // Uzimanje podataka iz forme
        var data = $(form).serialize();

        // Uzimanje vrednosti iz action atributa
        var action = $(form).prop('action');

        // Onemogućavanje svih polja
        $('input, textarea, button').prop('disabled', true);
        // Promena natpisa na dugmetu
        $(form).find('button').text('Slanje u toku...');

        // Slanje podataka iz forme putem AJAX metode
        $.post(
            action,
            data,
            function (response) {
                console.log(response);
                if (response == 1) {
                    // Sakrij i ukloni formu
                    $(form).slideUp(function () {
                        $(this).remove();
                    });
                    // Prikaži da je poruka uspešno poslata
                    $('.alert-success').slideDown();
                } else if ( response != '') {
                    // Ako poruka nije prosleđena - pokazaće se greška
                    alert(response);
                } else {
                    alert('Serverska validacija nije prošla');
                }
            }
        );
    }
});

$(".back-to-top").click(function () {
  $("html, body").animate({scrollTop:0},250);
});

$('#gallery .img-holder').magnificPopup({
    delegate : 'a',
    type : 'image',
    gallery : {
        enabled : true
    }
});

