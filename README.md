# Productive Shop test project

It is a test project to company [Productive Shop][ProductiveShop].

## Test task

The test task available by [link][TestTask].

## Project review

The project was developed on DDEV.
The localhost environment is shared by [Egrok][Egrok].
This link is temporary. It can be available only when my PC is working.
If the link doesn't work, don't hesitate to get in touch with me and I'll enable my PC.

## Credential

**_Super admin_**: admin / hyzqqWGJLqB9P8D

## Instruction to install at localhost

1. Navigate to your "projects" directory.
2. Clone repository from [GitHub][Repo].

`git clone https://github.com/bedstvie/productive_shop_test.git`

3. Switch to productive_shop_test directory.

`cd productive_shop_test`

4. Start project in ddev.

`ddev start`

5. Update libraries and packets via composer.

`ddev composer update --prefer-dist`

6. Import database via command or install manually using phpmyadmin. Database preset in repository in backups directory.

`ddev import-db --file=backups/db.sql`

7. Compile css files.

`cd web/themes/custom/ps
ddev npm install
ddev npm run compile`

8. Run project

`ddev launch`

[ProductiveShop]: https://productiveshopdev.kinsta.cloud/seo-case-studies
[TestTask]: https://docs.google.com/document/d/19hzaEJ4O75dNfRouJg9U1N-WjAV7ArssE7FWg5GQp04/edit?tab=t.0
[Egrok]: https://f11b-193-194-127-198.ngrok-free.app
[Repo]: https://github.com/bedstvie/productive_shop_test
