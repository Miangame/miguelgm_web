$(function () {

    let texts, back, index, x, count, p, time, div;
    texts = ['Web Developer.         ',
        " Programmer.         "];
    back = false;
    index = 0;
    count = 0;
    time = 150;
    p = $('span.write');
    div = $('div');

    let write = function () {
        x = setInterval(function () {
            if (back == false) {
                time = 80;

                p.text(p.text() + texts[index][count]);
                count++;

                if (count == texts[index].length) {
                    clearInterval(x);
                    back = true;
                    if (index == texts.length - 1) {
                        index = 0;
                    } else {
                        index++;
                    }
                    write();
                };

            } else {
                time = 150;

                count--;
                p.text(p.text().slice(0, count))


                if (count == 0) {
                    clearInterval(x);
                    back = false;
                    write();
                }

            }

        }, time);

    };

    write();

})