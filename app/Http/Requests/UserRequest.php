<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class UserRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			"txtUsername"=>"required",
			"txtName"=>"required",
			"txtEmail"=>"required",
		];
	}
	public function messages(){
		return[
			"txtUsername.required"=>"Vui lòng nhập username",
			"txtName.required"=>"Vui lòng nhập tên",
			"txtEmail.required"=>"Vui lòng nhập email",
		];
	}
}
