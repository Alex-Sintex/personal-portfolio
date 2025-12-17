import { describe, it, expect } from "vitest"
import { mount } from "@vue/test-utils"
import App from "../src/App.vue"

describe("App.vue", () => {
  it("renders the initial state", () => {
    const wrapper = mount(App)
    expect(wrapper.find("h1").exists()).toBe(true)
    expect(wrapper.find("h1").text()).toBe("0")
    expect(wrapper.find("button").exists()).toBe(true)
    expect(wrapper.find("button").text()).toBe("Increment")
  })

  it("increments the counter when button is clicked", async () => {
    const wrapper = mount(App)
    await wrapper.find("button").trigger("click")
    expect(wrapper.find("h1").text()).toBe("1")
  })
})
