<style>
    #galleryWithHorizontalThumbs .primary-gallery {
        overflow: hidden;
        margin-bottom: 15px;
    }
    #galleryWithHorizontalThumbs .primary-gallery .carousel-item {
        height: unset !important;
        position: relative;
        padding: unset !important;
    }
    #galleryWithHorizontalThumbs .primary-gallery .carousel-item img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-position: center;
        object-fit: contain;
    }
    #galleryWithHorizontalThumbs .primary-gallery .carousel-item.aspect-ratio-1-1 {
        padding-bottom: calc(100%) !important;
    }
    #galleryWithHorizontalThumbs .primary-gallery .carousel-item.aspect-ratio-4-3 {
        padding-bottom: calc(100% * 4 / 3) !important;
    }
    #galleryWithHorizontalThumbs .thumbs-gallery .item {
        position: relative;
        height: unset !important;
        padding: unset !important;
    }
    #galleryWithHorizontalThumbs .thumbs-gallery .item img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-position: center;
        object-fit: contain;
    }
    #galleryWithHorizontalThumbs .thumbs-gallery .item.aspect-ratio-1-1 {
        padding-bottom: calc(100%) !important;
    }
    #galleryWithHorizontalThumbs .thumbs-gallery .item.aspect-ratio-4-3 {
        padding-bottom: calc(100% * 4 / 3) !important;
    }

</style>