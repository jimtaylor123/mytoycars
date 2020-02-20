<template>

  <div style="height: 500px; width: 100%">
    <l-map
      :zoom="zoom"
      :center="center"
      :options="mapOptions"
      style="height: 80%"
      @update:center="centerUpdate"
      @update:zoom="zoomUpdate"
    >
      <l-tile-layer
        :url="url"
        :attribution="attribution"
      />
      <l-marker :lat-lng="location">
        <l-tooltip :options="{ permanent: true, interactive: true }">
          <div @click="innerClick">
            I am a tooltip
            <p v-show="showParagraph">
              Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque
              sed pretium nisl, ut sagittis sapien. Sed vel sollicitudin nisi.
              Donec finibus semper metus id malesuada.
            </p>
          </div>
        </l-tooltip>
      </l-marker>
    </l-map>
  </div>
</template>
<script>
    import { latLng } from "leaflet";
    import { LMap, LTileLayer, LMarker, LPopup, LTooltip, fixDefaultIcons } from "vue2-leaflet";
    fixDefaultIcons();

    export default {
        name: "Map",
        components: { LMap, LTileLayer, LMarker, LPopup, LTooltip },
        props: [
            'lat',
            'lng'
        ],
        data() {
            return {
                location: latLng(47.41422, -1.250482),
                center: latLng(47.41322, -1.219482),
                currentCenter: latLng(47.41322, -1.219482),
                zoom: 5,
                currentZoom: 11.5,
                url: 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
                attribution: '© OpenStreetMap contributors',
                showParagraph: false,
                mapOptions: { zoomSnap: 0.5 },
                showMap: true,
            };
        },
        mounted() {
            console.log('YES', this.lat, this.lng);
            this.location = latLng(this.lat, this.lng);
            this.center = latLng(this.lat, this.lng);
        },
        methods: {
            zoomUpdate(zoom) {
                this.currentZoom = zoom;
            },
            centerUpdate(center) { this.currentCenter = center; },
            showLongText() {
                this.showParagraph = !this.showParagraph;
            },
            innerClick() {
                alert("Click!"); }
            }
        };
</script>
