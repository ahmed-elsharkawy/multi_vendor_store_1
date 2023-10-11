<x-form.input name="first_name" type="text" :value="$user->profile->first_name" label="First Name" />
<x-form.input name="last_name" type="text" :value="$user->profile->last_name" label="Last Name" />
<x-form.input name="birthday" type="date" :value="$user->profile->birthday" label="Birthday" />
<x-form.radio name='gender' :checked="$user->profile->gender" :options="['Male' => 'male', 'Female' => 'female']" label="Gender" />

<x-form.input name="street_address" :value="$user->profile->street_address" label="Street Address" />
<x-form.input name="city" :value="$user->profile->city" label="City" />
<x-form.input name="state" :value="$user->profile->state" label="State" />
<x-form.input name="postal_code" :value="$user->profile->postal_code" label="Postal Code" />

<x-form.select name="country" label="Country" :value="$user->profile->country" :options="$countries" />
<x-form.select name="local" label="Local" :value="$user->profile->local" :options="$locales" />

<div class="form-group">
    <button class="btn btn-success" type="submit">{{ $btn_txt ?? 'Save' }}</button>
</div>
