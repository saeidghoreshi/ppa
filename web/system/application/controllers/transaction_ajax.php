<?php


class transaction_ajax extends Controller{
    function Transaction()
    {
        parent::Controller();
    }
    
    function annotation() {
        $ann_text = $this->input->post('ann_text');
        $ann_id = $this->input->post('ann_id');
        $data = array('result' => $ann_text);
        echo json_encode($data);
    }
}

?>
