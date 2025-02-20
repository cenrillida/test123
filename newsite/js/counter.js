async function setCounter(number, block) {

    var currentNumber = $('#'+block).html();
    number = number+"";

    if(number.length>currentNumber.length) {
        var diffLength = number.length-currentNumber.length;
        for(var s=0; s<diffLength; s++) {
            currentNumber = "0"+currentNumber;
        }
    }
    if(number.length<currentNumber.length) {
        var diffLengthR = currentNumber.length-number.length;
        currentNumber = currentNumber.substr(diffLengthR);
    }

    while (currentNumber!=number) {
        var newnumber = "";
        for (var digit = 0; digit < number.length; digit++) {
            if (currentNumber[digit] < number[digit]) {
                newnumber += (parseInt(currentNumber[digit])+1)+"";
            }
            if (currentNumber[digit] > number[digit]) {
                newnumber += (parseInt(currentNumber[digit])-1)+"";
            }
            if (currentNumber[digit] == number[digit]) {
                newnumber += currentNumber[digit]+"";
            }
        }
        currentNumber = newnumber;
        await new Promise(r => setTimeout(r, 30));
        $('#'+block).html(currentNumber);
    }
    $('#'+block).html(currentNumber);

    // if(number>currentNumber) {
    //     var diff = number-currentNumber;
    //     var speed = 100;
    //     var accelerateStep = 0;
    //     var stopStep = 0;
    //     var acceleration = 0;
    //     if(diff>50) {
    //         accelerateStep = currentNumber+20;
    //         stopStep = number-20;
    //         acceleration = 1;
    //         speed = 190;
    //     }
    //     for(var i=currentNumber;i<=number;i++) {
    //         await new Promise(r => setTimeout(r, speed));
    //         if(acceleration) {
    //             if (i <= accelerateStep) {
    //                 speed = speed - 9;
    //             }
    //             if (i >= stopStep) {
    //                 speed = speed + 9;
    //             }
    //         }
    //         $('#stat-views-counter').html(i);
    //     }
    // }
}