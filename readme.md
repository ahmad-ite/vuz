[![Fat-Free Framework](ui/images/logo.png)](http://fatfree.sf.net/)

**360VUZ**

# Requirements

- PHP ^8.1
- Composer ^2.0

# Installation

Clone the project

```bash
  git clone {repository link} app-name
```

Go to the project directory

```bash
  cd app-name
```

Checkout `main` branch

```bash
  git checkout main
```

Install dependencies

```bash
  composer install
```

```bash
   php -S localhost:8000
```

create DB and seed
create {vuz_bd} db and update db config in `app/config/database.ini`

run

```bash
  vendor/bin/phinx migrate
```

```bash
  vendor/bin/phinx seed:run
```

or use `vuz_db.sql` to insert schema and data

<!-- Tests User

```bash
  email: admin@test.com
  pass: password
``` -->

# Postman APIs

use `postman/collention.json`

# Callback Samples

use `webhook/-/-.json` samples
