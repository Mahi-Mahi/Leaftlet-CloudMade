
require 'oily_png'
require 'fileutils'

master = ChunkyPNG::Image.from_file('master.png')

x = 265460
y = 180414

(1..15).each do |i|
  
  (1..12).each do |j|
    
    x_crop = x + i
    y_crop = y + j

    p "#{x_crop} x #{y_crop}"
    
    new = master.crop(i * 256, j * 256, 256, 256)

    FileUtils.mkdir_p "19/#{x_crop}"
    
    new.save("19/#{x_crop}/#{y_crop}.png", :fast_rgba)
    
  end
  
end

