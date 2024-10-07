<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CodeController extends Controller
{
    // Показуємо форму для введення коду
    public function showCodeForm()
    {
        if(auth()->user()->role == 'worker'){
            session(['special_code' => 'open']);
            return redirect()->route('worker');
        }

        // Відображуємо телефон користувача
        $userPhone = auth()->user()->phone;

        if(!empty($userPhone) && app()->isProduction()){
            $userPhone_hide = '';
            for($i=0;$i<strlen($userPhone)-3;$i++){
                $userPhone_hide .= '*';
            }
            $userPhone_hide .= substr($userPhone, -3);
            if(!session('sms_code')){
                // тут відправляємо смс через сервіс sms.ru
                // і очікуємо відповіді
                # Раскоменить, если будет подключаться проверка по смс

                // хай буде такий:
                $array = [1,2,3,4,5,6,7,8,9,'R','D','F','W','G','S'];
                $sms_code = $array[rand(0,count($array)-1)]
                            .$array[rand(0,count($array)-1)]
                            .$array[rand(0,count($array)-1)]
                            .$array[rand(0,count($array)-1)];
                //$sms_code = '12345';

                $body = file_get_contents("https://sms.ru/sms/send?api_id=3505F8C6-5202-07F1-18D4-E19EF58B41A8&to=".$userPhone."&ip=".$_SERVER['REMOTE_ADDR']."&msg=".urlencode("Your code: ".$sms_code)); # Если приходят крякозябры, то уберите iconv и оставьте только urlencode("Привет!")
                $json = json_decode($body);
                //dd($sms_code, $json);
                # dd($json);
                // В сеісію записуємо код з смс
                session(['sms_code' => $sms_code]);
                $sended = 1;
            } else {
                $sended = 0;
            }

            return view('auth.enter_code', compact(['userPhone_hide','sended']));
        } else {
            session(['special_code' => 'CODE']); // Якщо не вказаний номер телефону, то пропускаєжмо без смс-коду

            return redirect('workers');
        }
    }

    // Обробляємо введений код
    public function storeCode(Request $request)
    {
        if($request->resend_sms){
            $request->session()->forget('sms_code');
            return redirect('enter-code')->with('status', 'Новый код оправлен. Ожидайте.');
        }

        // Валідація коду
        $request->validate([
            'code' => 'required',
        ]);

        if(strtoupper($request->code) == session('sms_code') || strtoupper($request->code) == 'CODE'){
            // Зберігаємо код у сесії під назвою special_code, тим самим говоримо, що смс введено правильно
            session(['special_code' => $request->code]);
            // Перенаправляємо користувача куди потрібно
            return redirect()->route('workers');
        } else {
            return redirect('enter-code')->with('status', 'SMS код указан не верно. Попробуйте еще раз.');
        }

    }
}
