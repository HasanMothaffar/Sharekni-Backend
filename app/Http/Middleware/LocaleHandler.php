<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LocaleHandler
{
	private $supported_locales = ['en', 'ar'];
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle(Request $request, Closure $next)
	{
		$locale = $request->header('Locale') ?? 'en';
		if (!in_array($locale, $this->supported_locales)) $locale = 'en';

		app()->setLocale($locale);
		return $next($request);
	}
}
