<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## API: OTP Auth + Admin/Client Management

### 1) Run migrations

```bash
php artisan migrate
```

### 2) Authentication flow (OTP only)

- `POST /api/auth/client/register`
	- Creates a `client` account (self-registration allowed only for clients).
	- Body:
		- `name` (required)
		- `phone` (required, unique)

- `POST /api/auth/otp/request`
	- Generates OTP for existing user (client or admin).
	- Body:
		- `phone` (required)
	- OTP is logged and returned only in local environment for testing.

- `POST /api/auth/otp/verify`
	- Verifies OTP and returns Sanctum Bearer token.
	- Body:
		- `phone` (required)
		- `otp` (required, 6 digits)

- `POST /api/auth/logout`
	- Requires `Authorization: Bearer <token>`.

### 3) Admin-only endpoints

All endpoints below require authenticated user role = `admin`.

- `GET /api/admins` : list admins
- `POST /api/admins` : create admin
- `GET /api/admins/{id}` : get one admin
- `PUT/PATCH /api/admins/{id}` : update admin
- `DELETE /api/admins/{id}` : delete admin

Admin creation is only available through `POST /api/admins` (no public admin register endpoint).

### 4) Admin endpoint for client data + filters + search

- `GET /api/clients`

Query params for filtering/searching:

- `q`: search in `name` and `phone` (example: `q=201`)
- `created_from`: date (`YYYY-MM-DD`)
- `created_to`: date (`YYYY-MM-DD`)
- `sort_by`: `name`, `phone`, `created_at`
- `sort_dir`: `asc` or `desc`
- `per_page`: 1 to 100

Example:

```text
GET /api/clients?q=201&created_from=2026-01-01&created_to=2026-12-31&sort_by=created_at&sort_dir=desc&per_page=20
```

- `GET /api/clients/{id}` : get one client

## API: Football Proxy (AllSportsAPI V2)

This project now exposes a public football proxy API that mirrors AllSportsAPI methods.

Behavior:

- Cache is based on query parameters only (not user/auth).
- If fresh cached data exists, API returns cached payload.
- If cache is missing or expired, API calls AllSportsAPI, stores the result, then returns it.

### Base endpoint (same style as provider doc)

- `GET|POST /api/football?met=Countries`
- `GET|POST /api/football?met=Leagues&countryId=5`
- `GET|POST /api/football?met=Fixtures&from=2021-05-18&to=2021-05-18`

### Friendly endpoints (optional)

- `GET|POST /api/football/countries`
- `GET|POST /api/football/leagues?countryId=5`
- `GET|POST /api/football/fixtures?from=2021-05-18&to=2021-05-18`
- `GET|POST /api/football/h2h?firstTeamId=93&secondTeamId=4973`
- `GET|POST /api/football/livescore`
- `GET|POST /api/football/standings?leagueId=207`
- `GET|POST /api/football/topscorers?leagueId=207`
- `GET|POST /api/football/teams?teamId=96`
- `GET|POST /api/football/players?playerId=103051168`
- `GET|POST /api/football/videos?eventId=86392`
- `GET|POST /api/football/odds?matchId=86392`
- `GET|POST /api/football/probabilities?matchId=86392`
- `GET|POST /api/football/live-odds`
- `GET|POST /api/football/live-comments?matchId=902316`
- `GET|POST /api/football/full-odds?matchId=1486610`

### Configuration

Set these environment variables:

- `ALL_SPORTS_API_KEY=your_key`
- `ALL_SPORTS_API_BASE_URL=https://apiv2.allsportsapi.com/football/`
- `ALL_SPORTS_API_TIMEOUT=30`
- `ALL_SPORTS_API_CONNECT_TIMEOUT=5`
- `ALL_SPORTS_API_RETRIES=1`

The response includes headers:

- `X-Data-Source: cache|provider`
- `X-Cached-At: <timestamp>` when served from cache
