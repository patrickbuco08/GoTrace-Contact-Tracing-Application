$(function() {
    //menu
    $('.menu').click(function() {
        $('nav ul').toggle();
    });

    //tab
    $('.tab button').click(function() {
        let tabId = $(this).attr('data-tab');

        $('.tab button').removeClass('current');
        $('.tabcontent').removeClass('current');

        $(this).addClass('current');
        $('#'+tabId).addClass('current');
    });

    //stick navbar to the top on scroll
    
    let stickyNavTop = $('.wrap-nav').offset().top;

    let stickyNav = function() {
        let scrollTop = $(window).scrollTop();

        if (scrollTop > stickyNavTop) { 
            $('.wrap-nav').addClass('sticky');
        } else {
            $('.wrap-nav').removeClass('sticky'); 
        }
    }

    stickyNav();
    
    //run it again every time you scroll
    $(window).scroll(function() {
       stickyNav();
    });
    
    
    $('.pgwSlider').pgwSlider({
        transitionEffect: 'sliding',
        displayControls: true,
        displayList: false
    });

    //form submission

    $('#contact-form').submit(function(e) {
        e.preventDefault();

        let name = $('#name').val(),
        email = $('#email').val(),
        subject = $('#subject').val(),
        message = $('#message').val();

        if (confirm(`Do you want your details to be submitted?\nName: ${name}\nEmail: ${email}\nSubject: ${subject}\nMessage: ${message}`)) {
            
            $.post('demo_test.php', 
                {
                    name: name,
                    email: email,
                    subject: subject,
                    message: message
                },
                function(data, status) {
                    if (status === 'success') {
                        alert(`${data}`);
                    } else {
                        alert(`Message did not submit: \nError: ${status}`);
                    }
                }
            );
        } else {
            alert('Your details not submitted');
        }

        $('#name').val(''),
        $('#email').val(''),
        $('#subject').val(''),
        $('#message').val('');
    });

});