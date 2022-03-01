<?php

namespace Modules\Admission\Http\Requests\Admin\Database\Manage\Registrant;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 */
	public function classMap($key)
	{
		$class = [
			'profile' => new \Modules\Admission\Http\Requests\Form\Profile\UpdateRequest(),
			'email' => new \Modules\Admission\Http\Requests\Form\Email\UpdateRequest(),
			'phone' => new \Modules\Admission\Http\Requests\Form\Phone\UpdateRequest(),
			'address' => new \Modules\Admission\Http\Requests\Form\Address\UpdateRequest(),
			'parent' => new \Modules\Admission\Http\Requests\Form\Parent\UpdateRequest(),
			'studies.store' => new \Modules\Admission\Http\Requests\Form\Studies\StoreRequest(),
			'studies.update' => new \Modules\Admission\Http\Requests\Form\Studies\UpdateRequest(),
			'studies.delete' => false,
			'organizations.store' => new \Modules\Admission\Http\Requests\Form\Organizations\StoreRequest(),
			'organizations.delete' => false,
			'achievements.store' => new \Modules\Admission\Http\Requests\Form\Achievements\StoreRequest(),
			'achievements.delete' => false,
			'file' => new \Modules\Admission\Http\Requests\Form\File\UploadRequest(),
			'test' => new \Modules\Admission\Http\Requests\Form\Test\AssignRequest(),
			'major' => new \Modules\Admission\Http\Requests\Form\Major\UpdateRequest(),
		];

		return $class[$key] ?? abort(404);
	}

	/**
	 * Get the validation rules that apply to the request.
	 */
	public function rules()
	{
		$key = $this->query('key', false);
		$mapper = $this->classMap($key);
		
		return $mapper ? $mapper->rules($this->query('uid')) : [];
	}

	/**
	 * Get custom attributes for validator errors.
	 */
	public function attributes()
	{
	    $key = $this->query('key', false);
	    $mapper = $this->classMap($key);

	    return $mapper ? $mapper->attributes() : [];
	}

	/**
	 * Determine if the user is authorized to make this request.
	 */
	public function authorize()
	{
	    return true;
	}
}
