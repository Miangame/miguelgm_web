$(function () {
    let fechaActual = new Date();
    let anioActual = fechaActual.getFullYear();
    let bandera = false;
    let bandera2 = false;

    $(window).scroll(function () {
        /**
        * Animación barras de habilidad
        */
        if ($(window).scrollTop() > 400 && !bandera) {
            $(".barra").each(function () {
                let porcentaje = parseInt($(this).html());
                if (porcentaje > 0) {
                    $(this).animate({
                        'width': '' + porcentaje + '%'
                    }, 2000);
                    bandera = true;
                } else {
                    $(this).css({
                        'color': 'black',
                        'background': 'none'
                    }, 800);
                }
            })
        }
        
        /**
         * Desplazamiento contacto
         */
        if ($(window).scrollTop() > 2345 && !bandera2) {
            $("#contactoNombre").css("animation", "desplazarDcha 2s");
            $("#contactoEmail").css("animation", "desplazarIzqda 2s");
            $("#contactoMsg").css("animation", "desplazarDcha 2s");

            $("#enviar").animate({
                opacity: "1"
            }, 2000);
            bandera2 = true;
        }
    });


    /**
     * Mostrar Texto Aside
     */
    $("#btnAsideInicio").hover(function () {
        $("#textoInicio").css("visibility", "visible")
    }, function () {
        $("#textoInicio").css("visibility", "hidden")
    }
    );

    $("#btnAsideSobre").hover(function () {
        $("#textoSobre").css("visibility", "visible")
    }, function () {
        $("#textoSobre").css("visibility", "hidden")
    }
    );

    $("#btnAsideSkills").hover(function () {
        $("#textoSkills").css("visibility", "visible")
    }, function () {
        $("#textoSkills").css("visibility", "hidden")
    }
    );

    $("#btnAsideProyectos").hover(function () {
        $("#textoProyectos").css("visibility", "visible")
    }, function () {
        $("#textoProyectos").css("visibility", "hidden")
    }
    );

    $("#btnAsideContacto").hover(function () {
        $("#textoContacto").css("visibility", "visible")
    }, function () {
        $("#textoContacto").css("visibility", "hidden")
    }
    );

    /**
     * Funcionalidad desplazamiento página
     */
    $("#btnAsideInicio").click(function () {
        $('html, body').animate({
            scrollTop: $("#header").offset().top
        }, 1000);
    });

    $("#downArrow, #btnAsideSobre").click(function () {
        $('html, body').animate({
            scrollTop: $("#sobreMi").offset().top
        }, 1000);
    });

    $("#btnAsideSkills").click(function () {
        $('html, body').animate({
            scrollTop: $("#skills").offset().top
        }, 1000);
    });

    $("#btnAsideProyectos").click(function () {
        $('html, body').animate({
            scrollTop: $("#proyectos").offset().top
        }, 1000);
    });

    $("#btnAsideContacto").click(function () {
        $('html, body').animate({
            scrollTop: $("#contacto").offset().top
        }, 1000);
    });

    /**
     * Efectos formulario de contacto
     */
    $("#contactoNombre").on("focus", function () {
        $("#labelNombre").css("opacity", "1");
        $("#contactoNombre").removeAttr("placeholder");
    });
    $("#contactoNombre").on("blur", function () {
        $("#labelNombre").css("opacity", "0");
        $("#contactoNombre").attr("placeholder", "Nombre:");
    });

    $("#contactoEmail").on("focus", function () {
        $("#labelEmail").css("opacity", "1");
        $("#contactoEmail").removeAttr("placeholder");
    });
    $("#contactoEmail").on("blur", function () {
        $("#labelEmail").css("opacity", "0");
        $("#contactoEmail").attr("placeholder", "Email:");
    });

    $("#contactoMsg").on("focus", function () {
        $("#labelMsg").css("opacity", "1");
        $("#contactoMsg").removeAttr("placeholder");
    });
    $("#contactoMsg").on("blur", function () {
        $("#labelMsg").css("opacity", "0");
        $("#contactoMsg").attr("placeholder", "Mensaje:");
    });

    /**
     * Mostrar año actual
     */
    $("#fecha").html(anioActual);

});