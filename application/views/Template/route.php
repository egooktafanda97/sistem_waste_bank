<?php if (auth()["role"] == "SUPER_ADMIN") {
    $this->load->view('/Template/route_dlh.php');
} else if (auth()["role"] == "ADMIN_BANK") {
    $this->load->view('/Template/route_bank.php');
}
