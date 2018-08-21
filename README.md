# Bolt FormStack Embed

Embed a Formstack form: https://michaelborn.formstack.com/forms/formtest onto your site.

## Usage

This function adds a new `formstackEmbedForm()` Twig function which you can use to embed a form by its id.

```
{{ formstackEmbedForm('1234') }}
```

## Requirements / Thank You!

Requires `jgulledge/formstack-api`.