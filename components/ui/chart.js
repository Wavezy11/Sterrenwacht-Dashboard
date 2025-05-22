export class Chart {
  constructor(ctx, config) {
    this.ctx = ctx
    this.config = config
    this.chart = new window.Chart(ctx, config)
  }

  update() {
    this.chart.update()
  }

  destroy() {
    this.chart.destroy()
  }
}
