# Events Module

The Event Module for AsgardCMS provides simple way to store events in the database and supports event repeat.

## Installation

Use the standard way ``composer require imagina/ievents-module``.

## Usage

### Event

####Api Routes

``https://mydomain.com/api/ivents/v1/event?``

filters
```json
filter={"categories":{1,2,3},"editor":[1,3,2], }

```
