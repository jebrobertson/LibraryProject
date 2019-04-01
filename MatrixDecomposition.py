#!/usr/bin/python
try:
    import numpy
except:
    print("To run package numpy is required")
    exit(0)

"""
@INPUT:
	R	: a matrix to factorize
	P	: The user matrix
	Q	: the book matrix
	K	: Number of latent features
	iterations	: number of times to optimize
	alpha	: the rate of approaching the optimal solution
	beta	: the regularization 
"""

def matrix_decomposition(R, P, Q, K, iterations=5000, alpha=.0002, beta=.02):
    Q = Q.T
    for step in range(iterations):
        for i in range(len(R)):
            for j in range(len(R[i])):
                if R[i][j] > 0:
                    error = R[i][j] - numpy.dot(P[i], Q[:,j])
                    for k in range(K):
                        P[i][k] += 2 * alpha * error * Q[k][j] - alpha * beta * P[i][k]
                        Q[k][j] += 2 * alpha * error * P[i][k] - alpha * beta * Q[k][j]

            eR = numpy.dot(P,Q)
            totalError = 0
            for i in range(len(R)):
                for j in range(len(R[i])):
                    if R[i][j] > 0:
                        totalError += pow(R[i][j] - numpy.dot(P[i], Q[:,j]), 2)
                        for k in range(K):
                            totalError += (beta/2) * ( pow(P[i][k], 2) + pow(Q[k][j], 2))
            if totalError < .001:
                break
        return P, Q.T




    
if __name__ == "__main__":
    R = [
         [5,3,0,1],
         [4,0,0,1],
         [1,1,0,5],
         [1,0,0,4],
         [0,1,5,4],
        ]

    R = numpy.array(R)

    N = len(R)
    M = len(R[0])
    K = 2

    P = numpy.random.rand(N,K)
    Q = numpy.random.rand(M,K)

    nP, nQ = matrix_decomposition(R, P, Q, K)
    print(nP)
    print(nQ)
    print(nP @ nQ.T)
