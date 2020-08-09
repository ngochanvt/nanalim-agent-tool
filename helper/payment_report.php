<?php
function get_ap_detail($ap_code){
    global $pdo;
    $sql = " SELECT w.*, wp.total_money, wp.total_order, wp.status as payment_status, wp.create_date, wp.payment_date, wp.payment_code, wp.payment_agency_id
            FROM g5_agency w LEFT JOIN g5_agency_payment wp ON w.agency_id = wp.agency_id 
            WHERE wp.payment_code = ?";
    $sta = $pdo->prepare($sql);
    $sta->execute(array($ap_code));
    return $sta->fetch(PDO::FETCH_ASSOC);
}

function get_wp_detail($wp_code){
     global $pdo;
    $sql = " SELECT w.*, wp.total_money, wp.total_order, wp.status as payment_status, wp.create_date, wp.payment_date, wp.payment_code, wp.payment_web_id
            FROM g5_web w LEFT JOIN g5_web_payment wp ON w.web_id = wp.web_id 
            WHERE wp.payment_code = ? ";
    $sta = $pdo->prepare($sql);
    $sta->execute(array($wp_code));
    return $sta->fetch(PDO::FETCH_ASSOC);
}

function get_agency_payment_report($agency_id){
    global $pdo;
    $sql = " SELECT w.*, 
                    SUM(wp.total_money)*count(DISTINCT wp.payment_agency_id)/count(*) AS total_money,
                    SUM(wp_requested.total_money)*count(DISTINCT wp_requested.payment_agency_id)/count(*) AS total_requested_money,
                    SUM(wp_completed.total_money)*count(DISTINCT wp_completed.payment_agency_id)/count(*) AS total_completed_money,
                    SUM(wp.total_order)*count(DISTINCT wp.payment_agency_id)/count(*) AS total_order,
                    SUM(wp_requested.total_order)*count(DISTINCT wp_requested.payment_agency_id)/count(*) AS total_requested_order,
                    SUM(wp_completed.total_order)*count(DISTINCT wp_completed.payment_agency_id)/count(*) AS total_completed_order
            FROM g5_agency w LEFT JOIN g5_agency_payment wp ON w.agency_id = wp.agency_id 
                        LEFT JOIN g5_agency_payment wp_requested ON w.agency_id = wp_requested.agency_id AND wp_requested.status = 'REQUESTED'
                        LEFT JOIN g5_agency_payment wp_completed ON w.agency_id = wp_completed.agency_id AND wp_completed.status = 'COMPLETED'
            WHERE w.agency_id = ? ";

    $sta = $pdo->prepare($sql);
    $sta->execute(array($agency_id));
    return $sta->fetch(PDO::FETCH_ASSOC);
}

function get_web_payment_report($web_id)
{
    global $pdo;
    $sql = " SELECT w.*, 
                    SUM(wp.total_money)*count(DISTINCT wp.payment_web_id)/count(*) AS total_money,
                    SUM(wp_requested.total_money)*count(DISTINCT wp_requested.payment_web_id)/count(*) AS total_requested_money,
                    SUM(wp_completed.total_money)*count(DISTINCT wp_completed.payment_web_id)/count(*) AS total_completed_money,
                    SUM(wp.total_order)*count(DISTINCT wp.payment_web_id)/count(*) AS total_order,
                    SUM(wp_requested.total_order)*count(DISTINCT wp_requested.payment_web_id)/count(*) AS total_requested_order,
                    SUM(wp_completed.total_order)*count(DISTINCT wp_completed.payment_web_id)/count(*) AS total_completed_order
            FROM g5_web w LEFT JOIN g5_web_payment wp ON w.web_id = wp.web_id 
                        LEFT JOIN g5_web_payment wp_requested ON w.web_id = wp_requested.web_id AND wp_requested.status = 'REQUESTED'
                        LEFT JOIN g5_web_payment wp_completed ON w.web_id = wp_completed.web_id AND wp_completed.status = 'COMPLETED'
            WHERE w.web_id = ?";

    $sta = $pdo->prepare($sql);
    $sta->execute(array($web_id));
    return $sta->fetch(PDO::FETCH_ASSOC);
}
?>