docker_compose := docker compose -f compose.test.yaml

test: clean
	$(docker_compose) up test --exit-code-from=test

test_coverage: clean
	$(docker_compose) up test_coverage --exit-code-from=test_coverage

test_watch:
	$(docker_compose) up test_watch --exit-code-from=test_watch

clean:
	$(docker_compose) down --volumes --remove-orphans --rmi=all

i18n:
	./vendor/bin/wp i18n make-pot . languages/i18n/awesome.pot \
		--slug=awesome \
		--domain=awesome \
		--include="config,includes,requirements,src,awesome.php" \
		--package-name="Awesome" \
		--headers='{ \
			"Language-Team": "en_US <dev@victorfreitas.tech>", \
			"Last-Translator": "Victor Freitas <dev@victorfreitas.tech>" \
		}'