<?php
class Book extends AbstractPost {

	protected $table = 'books';
	protected $key_field = 'book_id';
    protected $bool_fields = ['is_male', 'is_female'];
    protected $file_fields = ['check_url'];

	function __construct($post) {
		parent::__construct($post);
		return $this;
	}
    public function getProc() {
        return new Proc( $this->post->proc_id );
    }
    public function getSpec() {
        return new Spec( $this->post->spec_id );
    }
    public function getAge() {
        return new Age( $this->post->age_id );
    }
    public function sendSmsBook() {

        $gender = 'Мырза';
        if ( $this->post->is_female ) {
            $gender = 'Ханым';
        }

        $fullname = $this->post->name;
        $date = date('d.m.Y', strtotime($this->post->date));
        $time = date('H:i', strtotime($this->post->time));
        $specialist = $this->getSpec()->post->name;
        $procedure = $this->getProc()->post->title;
        $age = $this->post->age;

        if ( $this->post->proc_id == 2 ) {
            $text = "Құрметті {$fullname} {$gender},
Сіз {$date} күні, {$time} уақытында қабылдауға сәтті жазылдыңыз.
Маман: {$specialist}
Процедура: {$procedure}
Жасыңыз: {$age}

Егер қандай да бір сұрақтарыңыз болса, бізге хабарласыңыз. 
Келгеніңізді күтеміз 'Клиника' медициналық клиникасы!";

        } else {
            $text = "Құрметті {$fullname} {$gender},
Сіздің балаңыз {$date} күні, {$time} уақытында қабылдауға сәтті жазылды. 
Маман: {$specialist}
Процедура: {$procedure}
Жасыңыз: {$age}

Егер қандай да бір сұрақтарыңыз болса, бізге хабарласыңыз. 
Келгеніңізді күтеміз 'Клиника' медициналық клиникасы!";
        }

        return $this->sendSalebot($text);

    }
    public function sendSmsRemind() {

        $date = date('d.m.Y', strtotime($this->post->date));
        $time = date('H:i', strtotime($this->post->time));
        $specialist = $this->getSpec()->post->name;
        $procedure = $this->getProc()->post->title;

        $text = "Қайырлы күн! “Клиника” орталығы

Ертең записіңіз бар екенін еске салады. Күні және сағаты:
{$date} {$time}

Маман: {$specialist}
Процедура: {$procedure}

Сізді күтеміз!";

        return $this->sendSalebot($text);

    }
    function getCleanPhone() {
        $phone = preg_replace('![^0-9]+!', '', $this->post->phone);
        $phone_arr = str_split($phone);
        if ($phone_arr[0] == '8') {
            $phone_arr[0] = '7';
        }
        $phone = implode('', $phone_arr);
        return $phone;
    }
    function sendSalebot( $text ) {
        $token = '3583b848c82cad0c6ea499b49dd255d2';
        $url = 'https://chatter.salebot.pro/api/' . $token . '/whatsapp_message';
        $params = [
            "message" => $text,
            "phone" => $this->getCleanPhone()
        ];
        $data = json_encode($params);

        $ch = curl_init( $url );
        curl_setopt( $ch, CURLOPT_POST, 1);
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $data );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
}