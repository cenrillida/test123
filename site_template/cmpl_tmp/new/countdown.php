<?php
global $DB;

$countdown_values[0]['countdown_date'] = $page["COUNTDOWN_DATE"];
$countdown_values[0]['countdown_text'] = $page["COUNTDOWN_TEXT"];
$countdown_values[0]['countdown_text_en'] = $page["COUNTDOWN_TEXT_EN"];
if(!empty($countdown_values[0]['countdown_date'])) {
    preg_match("/([0-9]{4})\.([0-9]{2})\.([0-9]{2}) ([0-9]{2})\:([0-9]{2})/i", $countdown_values[0]['countdown_date'], $matches);
    $countdown_date = mktime($matches[4], $matches[5], 0, $matches[2], $matches[3], $matches[1]);
    $time = $countdown_date-time();

    $days = floor($time / 86400);
    $hours = floor(($time % 86400) / 3600);
    $minutes = floor(($time % 3600) / 60);
    $seconds = $time % 60;
    $digits_days = preg_split('//', $days, -1, PREG_SPLIT_NO_EMPTY);
    $digits_days = array_reverse($digits_days);
    if ($days <= 0) {
        $digits_days[0] = 0;
        $digits_days[1] = 0;
        $digits_days[2] = 0;
    }
    if (count($digits_days) == 1) {
        $digits_days[1] = 0;
        $digits_days[2] = 0;
    }
    if (count($digits_days) == 2) {
        $digits_days[2] = 0;
    }

    $digits_hours = preg_split('//', $hours, -1, PREG_SPLIT_NO_EMPTY);
    $digits_hours = array_reverse($digits_hours);
    if ($hours <= 0) {
        $digits_hours[0] = 0;
        $digits_hours[1] = 0;
    }
    if (count($digits_hours) == 1) {
        $digits_hours[1] = 0;
    }

    $digits_minutes = preg_split('//', $minutes, -1, PREG_SPLIT_NO_EMPTY);
    $digits_minutes = array_reverse($digits_minutes);
    if ($minutes <= 0) {
        $digits_minutes[0] = 0;
        $digits_minutes[1] = 0;
    }
    if (count($digits_minutes) == 1) {
        $digits_minutes[1] = 0;
    }

    $digits_seconds = preg_split('//', $seconds, -1, PREG_SPLIT_NO_EMPTY);
    $digits_seconds = array_reverse($digits_seconds);
    if ($seconds <= 0) {
        $digits_seconds[0] = 0;
        $digits_seconds[1] = 0;
    }
    if (count($digits_seconds) == 1) {
        $digits_seconds[1] = 0;
    }

    /*$newformat = date('Y-m-d',$time);
    var_dump($newformat);*/
    ?>
    <script type="text/javascript" src="/js/HackTimer.js"></script>
    <script type="text/javascript" src="/js/HackTimerWorker.js"></script>
    <script>
        var first_num_day = <?=$digits_days[2]?>;//������ ����� ��������
        var second_num_day = <?=$digits_days[1]?>;//������ ����� ��������
        var third_num_day = <?=$digits_days[0]?>;//������ ����� ��������
        var first_num_hour = <?=$digits_hours[1]?>;//������ ����� ��������
        var second_num_hour = <?=$digits_hours[0]?>;//������ ����� ��������
        var first_num_minute = <?=$digits_minutes[1]?>;//������ ����� ��������
        var second_num_minute = <?=$digits_minutes[0]?>;//������ ����� ��������
        var first_num_second = <?=$digits_seconds[1]?>;//������ ����� ��������
        var second_num_second = <?=$digits_seconds[0]?>;//������ ����� ��������
    </script>
    <div class="container-fluid countdowns">
        <div class="row justify-content-center">
            <div class="col-6 col-md-auto">
                <div>
                    <div class="countdown_block">
                        <div class="countdown countdown-day">
                            <span class="countdown_first_num"></span><span class="countdown_second_num"></span><span
                                class="countdown_third_num"></span>
                        </div>
                    </div>
                </div>
                <div class="text-center large-text-center"><?php if($_SESSION[lang]!="/en") echo '����'; else echo 'Days';?></div>
            </div>
            <div class="col-6 col-md-auto">
                <div>
                    <div class="countdown_block">
                        <div class="countdown countdown-hour">
                            <span class="countdown_first_num"></span><span class="countdown_second_num"></span>
                        </div>
                    </div>
                </div>
                <div class="text-center large-text-center"><?php if($_SESSION[lang]!="/en") echo '�����'; else echo 'Hours';?></div>
            </div>
            <div class="col-6 col-md-auto">
                <div>
                    <div class="countdown_block">
                        <div class="countdown countdown-minute">
                            <span class="countdown_first_num"></span><span class="countdown_second_num"></span>
                        </div>
                    </div>
                </div>
                <div class="text-center large-text-center"><?php if($_SESSION[lang]!="/en") echo '�����'; else echo 'Minutes';?></div>
            </div>
            <div class="col-6 col-md-auto">
                <div>
                    <div class="countdown_block">
                        <div class="countdown countdown-second">
                            <span class="countdown_first_num"></span><span class="countdown_second_num"></span>
                        </div>
                    </div>
                </div>
                <div class="text-center large-text-center"><?php if($_SESSION[lang]!="/en") echo '������'; else echo 'Seconds';?></div>
            </div>
        </div>
    </div>
    <div class="countdown_final">
        <div>
            <div class="countdown_final_box">
                <h2><?php if($_SESSION[lang]!='/en') echo $countdown_values[0]['countdown_text']; else echo $countdown_values[0]['countdown_text_en'];?></h2>
            </div>
        </div>
    </div>

    <script>
        function timer() {
            if (stop)
                return;

            if (second_num_second <= 0) {//���� ������ ����� �������� ������ ��� ����� 0
                second_num_second = 10;
                first_num_second = first_num_second - 1;
                if (first_num_second >= 0)
                    $(".countdown-second .countdown_first_num").animate({top: "50px", opacity: 0.0}, 100)
                        .animate({top: "-50px"}, 200, function () {
                            $(this).html(first_num_second);
                        })
                        .animate({top: "0px", opacity: 1}, 100)
                        .animate({top: "0px"}, 200);
            }

            if (first_num_second <= -1) {//���� ������ ����� �������� ������ ��� ����� -1
                second_num_second = 0;
                first_num_second = first_num_second + 1;
            }

            if (first_num_second == 0 && second_num_second == 0) {

                if (second_num_minute <= 0) {//���� ������ ����� �������� ������ ��� ����� 0
                    second_num_minute = 10;
                    first_num_minute = first_num_minute - 1;
                    if (first_num_minute >= 0)
                        $(".countdown-minute .countdown_first_num").animate({top: "50px", opacity: 0.0}, 100)
                            .animate({top: "-50px"}, 200, function () {
                                $(this).html(first_num_minute);
                            })
                            .animate({top: "0px", opacity: 1}, 100)
                            .animate({top: "0px"}, 200);
                }

                if (first_num_minute <= -1) {//���� ������ ����� �������� ������ ��� ����� -1
                    second_num_minute = 0;
                    first_num_minute = first_num_minute + 1;
                }
                if (first_num_minute == 0 && second_num_minute == 0) {

                    ///hours///
                    if (second_num_hour <= 0) {//���� ������ ����� �������� ������ ��� ����� 0
                        second_num_hour = 10;
                        first_num_hour = first_num_hour - 1;
                        if (first_num_hour >= 0)
                            $(".countdown-hour .countdown_first_num").animate({top: "50px", opacity: 0.0}, 100)
                                .animate({top: "-50px"}, 200, function () {
                                    $(this).html(first_num_hour);
                                })
                                .animate({top: "0px", opacity: 1}, 100)
                                .animate({top: "0px"}, 200);
                    }

                    if (first_num_hour <= -1) {//���� ������ ����� �������� ������ ��� ����� -1
                        second_num_hour = 0;
                        first_num_hour = first_num_hour + 1;
                    }
                    if (first_num_hour == 0 && second_num_hour == 0) {

                        //days//
                        if (second_num_day <= 0) {//���� ������ ����� �������� ������ ��� ����� 0
                            second_num_day = 10;
                            first_num_day = first_num_day - 1;
                            if (first_num_day >= 0)
                                $(".countdown-day .countdown_first_num").animate({top: "50px", opacity: 0.0}, 100)
                                    .animate({top: "-50px"}, 200, function () {
                                        $(this).html(first_num_day);
                                    })
                                    .animate({top: "0px", opacity: 1}, 100)
                                    .animate({top: "0px"}, 200);
                        }

                        if (first_num_day <= -1) {//���� ������ ����� �������� ������ ��� ����� -1
                            second_num_day = 0;
                            first_num_day = first_num_day + 1;
                        }

                        if (third_num_day <= 0) {//���� ������ ����� �������� ������ ��� ����� 0
                            third_num_day = 10;
                            second_num_day = second_num_day - 1;
                            if (second_num_day >= 0)
                                $(".countdown-day .countdown_second_num").animate({top: "50px", opacity: 0.0}, 100)
                                    .animate({top: "-50px"}, 200, function () {
                                        $(this).html(second_num_day);
                                    })
                                    .animate({top: "0px", opacity: 1}, 100)
                                    .animate({top: "0px"}, 200);
                        }

                        if (second_num_day <= -1) {//���� ������ ����� �������� ������ ��� ����� -1
                            third_num_day = 0;
                            second_num_day = second_num_day + 1;
                        }
                        if (first_num_day == 0 && second_num_day == 0 && third_num_day == 0) {
                            stop = true;
                            $(".countdowns").hide();
                            $(".countdown_final").show();
                            return;


                        }
                        else {
                            third_num_day = third_num_day - 1;
                            $(".countdown-day .countdown_third_num").animate({top: "50px", opacity: 0.0}, 100)
                                .animate({top: "-50px"}, 200, function () {
                                    $(this).html(third_num_day);
                                })
                                .animate({top: "0px", opacity: 1}, 100)
                                .animate({top: "0px"}, 200);
                        }

                        //days//


                        first_num_hour = 2;
                        second_num_hour = 3;
                        $(".countdown-hour .countdown_first_num").animate({top: "50px", opacity: 0.0}, 100)
                            .animate({top: "-50px"}, 200, function () {
                                $(this).html(first_num_hour);
                            })
                            .animate({top: "0px", opacity: 1}, 100)
                            .animate({top: "0px"}, 200);
                        $(".countdown-hour .countdown_second_num").animate({top: "50px", opacity: 0.0}, 100)
                            .animate({top: "-50px"}, 200, function () {
                                $(this).html(second_num_hour);
                            })
                            .animate({top: "0px", opacity: 1}, 100)
                            .animate({top: "0px"}, 200);

                    }
                    else {
                        second_num_hour = second_num_hour - 1;
                        $(".countdown-hour .countdown_second_num").animate({top: "50px", opacity: 0.0}, 100)
                            .animate({top: "-50px"}, 200, function () {
                                $(this).html(second_num_hour);
                            })
                            .animate({top: "0px", opacity: 1}, 100)
                            .animate({top: "0px"}, 200);
                    }
                    //hours///


                    first_num_minute = 5;
                    second_num_minute = 9;
                    $(".countdown-minute .countdown_first_num").stop();
                    $(".countdown-minute .countdown_first_num").stop();
                    $(".countdown-minute .countdown_first_num").stop();
                    $(".countdown-minute .countdown_first_num").stop();
                    $(".countdown-minute .countdown_first_num").animate({top: "50px", opacity: 0.0}, 100)
                        .animate({top: "-50px"}, 200, function () {
                            $(this).html(first_num_minute);
                        })
                        .animate({top: "0px", opacity: 1}, 100)
                        .animate({top: "0px"}, 200);
                    $(".countdown-minute .countdown_second_num").stop();
                    $(".countdown-minute .countdown_second_num").stop();
                    $(".countdown-minute .countdown_second_num").stop();
                    $(".countdown-minute .countdown_second_num").stop();
                    $(".countdown-minute .countdown_second_num").animate({top: "50px", opacity: 0.0}, 100)
                        .animate({top: "-50px"}, 200, function () {
                            $(this).html(second_num_minute);
                        })
                        .animate({top: "0px", opacity: 1}, 100)
                        .animate({top: "0px"}, 200);

                }
                else {
                    second_num_minute = second_num_minute - 1;
                    $(".countdown-minute .countdown_second_num").stop();
                    $(".countdown-minute .countdown_second_num").stop();
                    $(".countdown-minute .countdown_second_num").stop();
                    $(".countdown-minute .countdown_second_num").stop();
                    $(".countdown-minute .countdown_second_num").animate({top: "50px", opacity: 0.0}, 100)
                        .animate({top: "-50px"}, 200, function () {
                            $(this).html(second_num_minute);
                        })
                        .animate({top: "0px", opacity: 1}, 100)
                        .animate({top: "0px"}, 200);
                }


                first_num_second = 5;
                second_num_second = 9;
                $(".countdown-second .countdown_first_num").stop();
                $(".countdown-second .countdown_first_num").stop();
                $(".countdown-second .countdown_first_num").stop();
                $(".countdown-second .countdown_first_num").stop();
                $(".countdown-second .countdown_first_num").animate({top: "50px", opacity: 0.0}, 100)
                    .animate({top: "-50px"}, 200, function () {
                        $(this).html(first_num_second);
                    })
                    .animate({top: "0px", opacity: 1}, 100)
                    .animate({top: "0px"}, 200);
                $(".countdown-second .countdown_second_num").stop();
                $(".countdown-second .countdown_second_num").stop();
                $(".countdown-second .countdown_second_num").stop();
                $(".countdown-second .countdown_second_num").stop();
                $(".countdown-second .countdown_second_num").animate({top: "50px", opacity: 0.0}, 100)
                    .animate({top: "-50px"}, 200, function () {
                        $(this).html(second_num_second);
                    })
                    .animate({top: "0px", opacity: 1}, 100)
                    .animate({top: "0px"}, 200);
                setTimeout("timer()", 1000);
            }

            else {
                //$('.countdown-second').find('.countdown_second_num').clearQueue();
                second_num_second = second_num_second - 1;
                $(".countdown-second .countdown_second_num").stop();
                $(".countdown-second .countdown_second_num").stop();
                $(".countdown-second .countdown_second_num").stop();
                $(".countdown-second .countdown_second_num").stop();
                $(".countdown-second .countdown_second_num").animate({top: "50px", opacity: 0.0}, 100)
                    .animate({top: "-50px"}, 200, function () {
                        $(this).html(second_num_second);
                    })
                    .animate({top: "0px", opacity: 1}, 100)
                    .animate({top: "0px"}, 200);
                setTimeout("timer()", 1000);
            }

        }

        var stop = false;
        /*var first_num_day = 1;//������ ����� ��������
        var second_num_day = 1;//������ ����� ��������
        var third_num_day = 1;//������ ����� ��������
        var first_num_hour = 0;//������ ����� ��������
        var second_num_hour = 0;//������ ����� ��������
        var first_num_minute = 0;//������ ����� ��������
        var second_num_minute = 0;//������ ����� ��������
        var first_num_second = 0;//������ ����� ��������
        var second_num_second = 5;//������ ����� ��������*/
        $(document).ready(function () {
            if (first_num_day !== -100) {
                $(".countdown-day .countdown_first_num").html(first_num_day);//������� ������ ����� ��������
                $(".countdown-day .countdown_second_num").html(second_num_day);//������� ������ ����� ��������
                $(".countdown-day .countdown_third_num").html(third_num_day);//������� ������ ����� ��������
                $(".countdown-hour .countdown_first_num").html(first_num_hour);//������� ������ ����� ��������
                $(".countdown-hour .countdown_second_num").html(second_num_hour);//������� ������ ����� ��������
                $(".countdown-minute .countdown_first_num").html(first_num_minute);//������� ������ ����� ��������
                $(".countdown-minute .countdown_second_num").html(second_num_minute);//������� ������ ����� ��������
                $(".countdown-second .countdown_first_num").html(first_num_second);//������� ������ ����� ��������
                $(".countdown-second .countdown_second_num").html(second_num_second);//������� ������ ����� ��������
                timer();//��������� ������� ��������
            }
        });
    </script>
    <?php
}
?>