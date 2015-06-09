install:
	@composer install
	@/usr/bin/php vendor/bin/phpdoc.php

generate-lessons:
	@/usr/bin/php app/bin/generateLessons.php

update:
	@git pull
	@composer update

doc: update
	@/usr/bin/php vendor/bin/phpdoc.php