<template>
  <div>
    <div class="main-card mb-3 card">
      <div class="card-body">
        <ul class="progress-indicator">
          <li
              v-for="{ label, value } in progressList"
              :key="value"
              :class="{
                completed: progressValues.currentId !== value && progressValues.completedIds.includes(value),
                danger: progressValues.currentId !== value && progressValues.errorIds.includes(value),
                active: progressValues.currentId === value,
              }"
              @click="onChange(value)"
          >
            <span class="bubble"></span>
            {{ label }}
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>
<script>
  import _ from 'lodash';

  // this array affects the order of the progress bar
  const PROGRESS_LIST = [{
    value: 'filename',
    label: 'Create filename'
  },
    {
      value: 'chemical',
      label: 'Chemical profile'
    },
    {
      value: 'human',
      label: 'Human impact'
    },
    {
      value: 'ecology',
      label: 'Ecological impact'
    },
    {
      value: 'groundwater',
      label: 'Groundwater impact'
    },
    {
      value: 'finish',
      label: 'Finish!'
    },
  ];

  export default {
    props: {
      progressValues: Object,
      onChange: Function, // onChange(value)
    },

    data() {
      return {
        progressList: PROGRESS_LIST,
      };
    },
  }

</script>
<style lang="scss">
  .progress-indicator {
    display: flex;
    margin: 1em 0 1em;
    padding: 0;
    font-size: 80%;
    text-transform: uppercase;

    &.stacked {
      display: block;
    }

    >li {
      flex: 1;
      list-style: none;
      text-align: center;
      width: auto;
      padding: 0;
      margin: 0;
      position: relative;
      text-overflow: ellipsis;
      color: #bbb;
      cursor: pointer;

      &:hover {
        color: #6f6f6f;
      }

      &.completed {
        color: #16aa4f;

        .bubble,
        .bubble:after,
        .bubble:before {
          background-color: #16aa4f;
          border-color: #247830;
        }
      }

      &.active {
        color: #0b493a;

        .bubble {
          color: #0b493a;

          &,
          &:before,
          &:after {
            background-color: #0b493a;
            border-color: #122a3f
          }
        }
      }

      &.danger {
        .bubble {
          color: #d3140f;

          &,
          &:before,
          &:after {
            background-color: #d3140f;
            border-color: #440605
          }
        }
      }

      &.warning {
        .bubble {
          color: #edb10a;

          &,
          &:before,
          &:after {
            background-color: #edb10a;
            border-color: #5a4304
          }
        }
      }

      &.info {
        .bubble {
          color: #5b32d6;

          &,
          &:before,
          &:after {
            background-color: #5b32d6;
            border-color: #25135d
          }
        }
      }

      .bubble {
        color: #16aa4f;
        border-radius: 1000px;
        width: 20px;
        height: 20px;
        background-color: #bbb;
        display: block;
        margin: 0 auto .5em;
        border-bottom: 1px solid #888;

        &:after,
        &:before {
          display: block;
          position: absolute;
          top: 9px;
          width: 100%;
          height: 3px;
          content: '';
          background-color: #bbb;
        }

        &:before {
          left: 0;
        }

        &:after {
          right: 0;
        }
      }

      &:first-child .bubble:after,
      &:first-child .bubble:before {
        width: 50%;
        margin-left: 50%;
      }

      &:last-child .bubble:after,
      &:last-child .bubble:before {
        width: 50%;
        margin-right: 50%
      }

      a:hover .bubble {
        color: #5671d0;

        &,
        &:before,
        &:after {
          background-color: #5671d0;
          border-color: #1f306e;
        }
      }
    }
  }

  @media handheld,
  screen and (max-width:400px) {
    .progress-indicator {
      font-size: 60%
    }
  }

</style>
