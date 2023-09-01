<?php

namespace Modules\Notification\Services;

class WhatsappService
{
    /**
     * @param $data (From Imagina Notification)
     * @param $template (From another module)
     */
    public function createTemplate($provider = null, $data = null, $template = null)
    {
        // Default parameters (fields)
        if (is_null($template)) {
            $parameters = [['type' => 'text', 'text' => $data['message']]];
        } else {
            $parameters = $template['parameters'];
        }

        $template = [
            'name' => $template['name'] ?? $provider->fields->defaultTemplate ?? null,
            'language' => $template['locale'] ?? $provider->fields->defaultTemplateLocale ?? null,
            'components' => [
                ['type' => 'body', 'parameters' => $parameters],
            ],
        ];

        return $template;
    }
}
