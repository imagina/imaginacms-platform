@php
    $primary = setting("isite::brandPrimary");
    $primaryContrast = setting("isite::primaryContrast");
    $secondary = setting("isite::brandSecondary");
    $secondaryContrast = setting("isite::secondaryContrast");
    $tertiary = setting("isite::brandTertiary");
    $tertiaryContrast = setting("isite::tertiaryContrast");
    $quaternary = setting("isite::brandQuaternary");
    $quaternaryContrast = setting("isite::quaternaryContrast");
    $success = setting("isite::brandPositive");
    $info = setting("isite::brandInfo");
    $warning = setting("isite::brandWarning");
    $danger = setting("isite::brandNegative");
    $dark = setting("isite::brandDark");
@endphp
<style>
    :root {
        --primary: {{$primary}};
        --primary-contrast: {{$primaryContrast}};
        --secondary: {{$secondary}};
        --secondary-contrast: {{$secondaryContrast}};
        @if(!empty($tertiary)) --tertiary: {{$tertiary}}; @endif
        @if(!empty($tertiaryContrast)) --tertiary-contrast: {{$tertiaryContrast}}; @endif
        @if(!empty($quaternary)) --quaternary: {{$quaternary}}; @endif
        @if(!empty($quaternaryContrast)) --quaternary-contrast: {{$quaternaryContrast}}; @endif
        --success: {{$success}};
        --info: {{$info}};
        --warning: {{$warning}};
        --danger: {{$danger}};
        --dark: {{$dark}};
    }
</style>