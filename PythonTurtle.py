from turtle import *
canvas = Screen()
canvas.bgcolor("lightgreen")
canvas.setup(400,400)

triangle = Turtle()
triangle.pensize(3)
triangle.forward(50)
triangle.left(120)
triangle.forward(50)
triangle.left(120)
triangle.forward(50)
triangle.left(120)

square = Turtle()
square.begin_fill()
square.color("blue")
square.forward(50)
square.left(90)
square.forward(50)
square.left(90)
square.forward(50)
square.left(90)
square.forward(50)
square.left(90)
square.end_fill()


canvas.exitonclick()